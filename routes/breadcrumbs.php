<?php 

// Home
Breadcrumbs::register('inicio', function($breadcrumbs)
{
    $breadcrumbs->push('Inicio', route('inicio'));
});

// Home > About
Breadcrumbs::register('creacion', function($breadcrumbs)
{
     $breadcrumbs->parent('Estudio Socioecónomico');
    $breadcrumbs->push('Creación/Modificación de Estudio Socioecónomico', route('creacion'));
});

Breadcrumbs::register('dictaminacion', function($breadcrumbs)
{
    $breadcrumbs->push('Dictaminación del Banco de Proyectos', route('dictaminacion'));
});

Breadcrumbs::register('consulta_banco', function($breadcrumbs)
{
    $breadcrumbs->push('Consulta de Banco de Proyectos', route('consulta_banco'));
});

// // Home > Blog
// Breadcrumbs::register('blog', function($breadcrumbs)
// {
//     $breadcrumbs->parent('home');
//     $breadcrumbs->push('Blog', route('blog'));
// });

// // Home > Blog > [Category]
// Breadcrumbs::register('category', function($breadcrumbs, $category)
// {
//     $breadcrumbs->parent('blog');
//     $breadcrumbs->push($category->title, route('category', $category->id));
// });

// // Home > Blog > [Category] > [Page]
// Breadcrumbs::register('page', function($breadcrumbs, $page)
// {
//     $breadcrumbs->parent('category', $page->category);
//     $breadcrumbs->push($page->title, route('page', $page->id));
// });