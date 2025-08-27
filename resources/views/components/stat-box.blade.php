@props(['title', 'value', 'bg' => 'primary'])

<div class="card text-white bg-{{ $bg }} mb-3 shadow-sm">
    <div class="card-body">
        <h6 class="card-title">{{ $title }}</h6>
        <h4 class="fw-bold">{{ $value }}</h4>
    </div>
</div>
