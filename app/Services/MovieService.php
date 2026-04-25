<?php
namespace App\Services;

use App\Repositories\MovieRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class MovieService implements MovieServiceInterface {
    protected $movieRepository;

    public function __construct(MovieRepositoryInterface $movieRepository) {
        $this->movieRepository = $movieRepository;
    }

    public function createMovie($data) {
        return $this->movieRepository->create($data);
    }

    public function getMovie($id) {
        return $this->movieRepository->find($id);
    }

    public function listMovie(int $paginate, $search) {
        $query = $this->movieRepository->list();
        if ($search) {
            $query->where('judul', 'like', '%' . request('search') . '%')
                ->orWhere('sinopsis', 'like', '%' . request('search') . '%');
        }
        $movies = $query->paginate($paginate)->withQueryString();

        return $movies;
    }

    public function updateMovie($id, $data, $request) {
        $movie = $this->movieRepository->find($id);

        $payload = [
            'judul' => $data['judul'],
            'sinopsis' => $data['sinopsis'],
            'category_id' => $data['category_id'],
            'tahun' => $data['tahun'],
            'pemain' => $data['pemain']
        ];

        if ($request->hasFile('foto_sampul')) {
            $randomName = Str::uuid()->toString();
            $fileExtension = $request->file('foto_sampul')->getClientOriginalExtension();
            $fileName = $randomName . '.' . $fileExtension;

            $request->file('foto_sampul')->move(public_path('images'), $fileName);

            $oldPath = public_path('images/' . $movie->foto_sampul);
            if ($movie->foto_sampul && File::exists($oldPath)) {
                File::delete($oldPath);
            }

            $payload['foto_sampul'] = $fileName;
        }

        return $this->movieRepository->update($id, $payload);
    }

    public function deleteMovie($id) {
        $movie = $this->movieRepository->find($id);

        $oldPath = public_path('images/' . $movie->foto_sampul);
        if ($movie->foto_sampul && File::exists($oldPath)) {
            File::delete($oldPath);
        }

        return $this->movieRepository->delete($id);
    }
}
