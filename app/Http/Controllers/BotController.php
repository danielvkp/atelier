<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BlogImport;
use App\Models\Categoria;
use App\Models\Blog;
use Str;
use Carbon\Carbon;
use File;
use Storage;

class BotController extends Controller
{
    public function getBlogs(){
      $items = Blog::where('imagen', '!=', 'n/a')->get(['meta_keywords', 'imagen']);

      $map = collect($items)->filter(function($item){
        return !Storage::disk('blog')->exists($item['imagen']);

        //return $item['meta_keywords'];
      })->values()->map(function ($item_b){
        return $item_b['meta_keywords'];
      });

      return response()->json($map, 200);

    }

    public function scrap(string $slug, Request $request){
      $blog = Blog::where('slug', "{$slug}/")->get()->first();
      $blog->cotenido = $request->contenido;
      $blog->imagen = $request->imagen;
      $blog->save();
      return response()->json($blog, 200);
    }

    private function retornarId($nombre_categoria){
      $nombre_sin_espacio = ltrim($nombre_categoria);
      $categoria_db = Categoria::where('nombre', 'like', "%{$nombre_sin_espacio}%")->get(['id', 'nombre'])->first();
      return $categoria_db['id'];
    }



    private function saveBlogs($arreglo){

      foreach ($arreglo as $key => $blog) {

        $blog = Blog::create([
          'meta_keywords' => $blog['url'],
          'meta_contenido' => 'n/a',
          'visitas' => 1,
          'titulo' => $blog['titulo'],
          'slug' => $blog['slug'],
          'autor' => 'Vanesa Hernandez',
          'cotenido' => 'n/a',
          'imagen' => 'n/a',
          'created_at' => $blog['created_at'],
        ]);

        $blog->categoria()->sync($blog['categorias']);
      }
      return Blog::all();

    }


    private function saveRelaciones($arreglo){

      foreach ($arreglo as $key => $blog) {
        $item = Blog::where('slug', "{$blog['slug']}")->get()->first();
        if($item){
          $item->categoria()->sync($blog['categorias']);
        }
      }

      return Blog::with('categoria')->get();

    }


    public function bot(){
      $archivo = Excel::toArray(new BlogImport, 'export-all-urls-440746.csv');

      array_shift($archivo[0]);

      $collection = collect($archivo[0])->map(function  ($fila) {
        $slug = Str::substr($fila[1], 28);
        $url = $fila[1];
        $titulo = $fila[0];
        $created_at = Carbon::parse($fila[4]);

        $nombres_categoria = Str::of($fila[2])->explode(',');

        $ids_categoria = $nombres_categoria->map(function ($nombre_categoria){
          return $this->retornarId($nombre_categoria);
        });

        return [
          'created_at' => $created_at,
          'titulo'     => $titulo,
          'url'        => $url,
          'slug'       => $slug,
          'categorias' => $ids_categoria
        ];
      });

      return $this->saveRelaciones($collection);
      //return $this->saveBlogs($collection);
    }

    public function categorias(){
      $categorias = [
          "Emociones",
          "Relaciones familiares",
          "Estudiar psicología",
          "Abordaje en Consulta",
          "Conductas adictivas",
          "Psicología Social",
          "Patologías",
          "Infantil",
          "Conceptos psicoanalíticos",
          "Cajon de sastre",
          "Terapias alternativas",
          "Obras Sigmund Freud",
          "Curiosidades de consulta",
          "Conceptos en Psicología",
          "PUBLICACIONES TÉCNICAS",
          "Testimonios",
          "Cajon de sastre ",
          "Hipnosis",
          "Covid-19",
          "casos clínicos",
          "Eneagrama",
          "genograma",
          "Los afectos",
          "TIPOS DE TERAPIAS",
          "PAREJAS",
          "La comida",
          "Trabajo Fin de Máster",
          "Trabajos finales"
      ];

      /*$collection = collect($categorias);

      $unique_data = $collection->unique()->values()->all();

      return $unique_data;*/

      foreach ($categorias as $key => $value) {
        Categoria::create([
          'nombre' => $value
        ]);
      }
      return Categoria::all();
    }
}
