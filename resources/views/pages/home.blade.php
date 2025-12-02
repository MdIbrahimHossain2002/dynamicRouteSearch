@extends('layouts.app')

@section('content')
<h1 class="mb-4">Home Page</h1>

<!-- Input Field -->
<input 
    type="text" 
    id="searchRoute" 
    class="form-control mb-3" 
    placeholder="Type to see routes..."
>

<!-- Output Area -->
<ul id="routeList"></ul>

<script>
document.addEventListener('DOMContentLoaded', () => {
    
    const search = document.getElementById('searchRoute');
    const list = document.getElementById('routeList');

    let allRoutes = [];

    // Fetch all routes from controller
    fetch('/routes-json')
        .then(res => res.json())
        .then(data => {
            allRoutes = data;
        });

    // When typing in input field
    search.addEventListener('keyup', () => {
        const value = search.value.toLowerCase();
        const filtered = allRoutes.filter(route =>
            route.name.toLowerCase().includes(value)
        );

        list.innerHTML = "";

        filtered.forEach(r => {
            list.innerHTML += `
                <li class="mt-2">
                    <strong>${r.name}</strong> — 
                    <a href="${r.url}" target="_blank">${r.url}</a>
                </li>
            `;
        });
    });
});
</script>

@endsection
