<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Services\MovieServiceInterface;
use App\Services\CategoryServiceInterface;

class MovieController extends Controller
{
    protected $movieService;
    protected $categoryService;

    public function __construct(MovieServiceInterface $movieService, CategoryServiceInterface $categoryService) {
        $this->movieService = $movieService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $movies = $this->movieService->listMovie(6, request('search'));
        return view('homepage', compact('movies'));
    }

    public function detail($id)
    {
        $movie = $this->movieService->getMovie($id);
        return view('detail', compact('movie'));
    }

    public function create()
    {
        $categories = $this->categoryService->listCategory();
        return view('input', compact('categories'));
    }

    public function store(StoreMovieRequest $request)
    {
        // Ambil data yang sudah tervalidasi
        $validated = $request->validated();

        // Simpan file foto jika ada
        if ($request->hasFile('foto_sampul')) {
            $validated['foto_sampul'] = $request->file('foto_sampul')->store('movie_covers', 'public');
        }

        $this->movieService->createMovie($validated);

        return redirect('/')->with('success', 'Film berhasil ditambahkan.');
    }

    public function data()
    {
        $movies = $this->movieService->listMovie(10, null);
        return view('data-movies', compact('movies'));
    }

    public function form_edit($id)
    {
        $movie = $this->movieService->getMovie($id);
        $categories = $this->categoryService->listCategory();
        return view('form-edit', compact('movie', 'categories'));
    }

    public function update(StoreMovieRequest $request, $id)
    {
        // Validasi data
        $validated = $request->validated();

        $this->movieService->updateMovie($id, $validated, $request);

        return redirect('/movies/data')->with('success', 'Data berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->movieService->deleteMovie($id);

        return redirect('/movies/data')->with('success', 'Data berhasil dihapus');
    }
}
