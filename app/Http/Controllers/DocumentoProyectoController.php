<?php

namespace App\Http\Controllers;

use App\Models\DocumentoProyecto;
use App\Models\Proyecto;
use App\Models\TipoDocumento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentoProyectoController extends Controller
{
    public function index(Proyecto $proyecto): View
    {
        $documentos = $proyecto->documentos()
            ->with(['tipo', 'subidoPor'])
            ->where('activo', true)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $tipos = TipoDocumento::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view(
            'documentos.index',
            compact(
                'proyecto',
                'documentos',
                'tipos'
            )
        );
    }

    public function store(
        Request $request,
        Proyecto $proyecto
    ): RedirectResponse {
        $datos = $request->validate([
            'tipo_documento_id' => [
                'required',
                'exists:tipos_documento,id',
            ],
            'archivo' => [
                'required',
                'file',
                'max:10240',
                'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png',
            ],
            'descripcion' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'fecha_documento' => [
                'nullable',
                'date',
            ],
        ]);

        $archivo = $request->file('archivo');

        $extension = strtolower(
            $archivo->getClientOriginalExtension()
        );

        $nombreAlmacenado =
            Str::uuid()->toString()
            . '.'
            . $extension;

        $directorio =
            'proyectos/'
            . $proyecto->id
            . '/expediente';

        $ruta = $archivo->storeAs(
            $directorio,
            $nombreAlmacenado,
            'local'
        );

        $rutaCompleta = Storage::disk('local')
            ->path($ruta);

        $hash = hash_file(
            'sha256',
            $rutaCompleta
        );

        DocumentoProyecto::create([
            'proyecto_id' =>
                $proyecto->id,

            'tipo_documento_id' =>
                $datos['tipo_documento_id'],

            'nombre_original' =>
                $archivo->getClientOriginalName(),

            'nombre_almacenado' =>
                $nombreAlmacenado,

            'ruta_archivo' =>
                $ruta,

            'mime_type' =>
                $archivo->getMimeType(),

            'tamano_bytes' =>
                $archivo->getSize(),

            'hash_archivo' =>
                $hash,

            'descripcion' =>
                $datos['descripcion'] ?? null,

            'fecha_documento' =>
                $datos['fecha_documento'] ?? null,

            'subido_por_id' =>
                $request->user()->id,

            'activo' => true,
        ]);

        return back()->with(
            'success',
            'El documento se agregó al expediente correctamente.'
        );
    }

    public function download(
        Proyecto $proyecto,
        DocumentoProyecto $documento
    ): StreamedResponse {
        abort_unless(
            (int) $documento->proyecto_id
                === (int) $proyecto->id,
            404
        );

        abort_unless(
            $documento->activo,
            404
        );

        abort_unless(
            Storage::disk('local')
                ->exists($documento->ruta_archivo),
            404
        );

        return Storage::disk('local')->download(
            $documento->ruta_archivo,
            $documento->nombre_original
        );
    }

    public function destroy(
        Proyecto $proyecto,
        DocumentoProyecto $documento
    ): RedirectResponse {
        abort_unless(
            (int) $documento->proyecto_id
                === (int) $proyecto->id,
            404
        );

        $documento->update([
            'activo' => false,
        ]);

        return back()->with(
            'success',
            'El documento se retiró del expediente.'
        );
    }
}
