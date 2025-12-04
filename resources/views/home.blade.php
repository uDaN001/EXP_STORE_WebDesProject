@extends('layouts.app')

@section('title', 'EXP GAME STORE - Home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/storefront.css') }}">
@endpush

@section('content')
<main class="storefront">
    <!-- FEATURED GAMES SECTION -->
    <section class="featured-section">
        <h2 class="featured-title">FEATURED GAMES</h2>

        <!-- MAIN GAME BANNER -->
        <div class="banner-container">
                @php
                // Use featuredGames if provided, otherwise fallback to popularGames
                $displayFeaturedGames = isset($featuredGames) && $featuredGames->count() > 0 ? $featuredGames->take(6) : ($popularGames->count() > 0 ? $popularGames->take(6) : collect());
                $firstGame = $displayFeaturedGames->first();
            @endphp
            
            @if($firstGame)
                <img id="banner-image" class="banner-img" 
                     src="{{ $firstGame->banner_url ?: ($firstGame->image_url ?: asset('css/assets/gamebanner_placeholder.jpg')) }}" 
                     alt="{{ $firstGame->title }}">

                <!-- Overlay Box -->
                <div class="banner-overlay">
                    <img id="banner-poster" class="banner-poster" 
                         src="{{ $firstGame->poster_url ?: ($firstGame->image_url ?: asset('css/assets/game1.jpg')) }}" 
                         alt="{{ $firstGame->title }}">
                    <h3 id="banner-title" class="banner-title">{{ $firstGame->title }}</h3>
                </div>
            @else
                <img id="banner-image" class="banner-img" src="{{ asset('css/assets/gamebanner_placeholder.jpg') }}" alt="Featured Game">
                <div class="banner-overlay">
                    <img id="banner-poster" class="banner-poster" src="{{ asset('css/assets/game1.jpg') }}" alt="Game Poster">
                    <h3 id="banner-title" class="banner-title">Featured Game</h3>
                </div>
            @endif
        </div>

        <!-- PREVIEW THUMBNAILS -->
        <div class="preview-row">
            @if($displayFeaturedGames->count() > 0)
                @foreach($displayFeaturedGames as $index => $game)
                    <div class="preview-box" 
                         data-banner="{{ $game->banner_url ?: ($game->image_url ?: asset('css/assets/gamebanner_placeholder' . (($index % 5) + 1) . '.jpg')) }}" 
                         data-poster="{{ $game->poster_url ?: ($game->image_url ?: asset('css/assets/game' . (($index % 5) + 1) . '.jpg')) }}" 
                         data-title="{{ $game->title }}"
                         style="background-image: url('{{ $game->poster_url ?: ($game->image_url ?: asset('css/assets/game' . (($index % 5) + 1) . '.jpg')) }}');">
                    </div>
                @endforeach
            @else
                @for($i = 1; $i <= 6; $i++)
                    <div class="preview-box" 
                         data-banner="{{ asset('css/assets/gamebanner_placeholder' . $i . '.jpg') }}" 
                         data-poster="{{ asset('css/assets/game' . $i . '.jpg') }}" 
                         data-title="Game {{ $i }}"
                         style="background-image: url('{{ asset('css/assets/game' . $i . '.jpg') }}');">
                    </div>
                @endfor
            @endif
        </div>
    </section>

    <!-- POPULAR GAMES SECTION -->
    <section class="popular-games">
        <h2 class="section-title">POPULAR GAMES</h2>

        <div class="games-container scroll-wrapper">
            <button class="scroll-btn left" aria-label="Scroll left">‹</button>
            <div class="games-list scroll-row">
                @forelse($popularGames->take(6) as $index => $game)
                    <div class="game-card-wrapper" onclick="window.location='{{ route('games.show', $game->id) }}'">
                        <div class="game-card">
                            <img src="{{ $game->poster_url ?: ($game->image_url ?: asset('css/assets/game' . (($index % 5) + 1) . '.jpg')) }}" alt="{{ $game->title }}">
                        </div>
                    </div>
                @empty
                    @for($i = 1; $i <= 6; $i++)
                        <div class="game-card-wrapper">
                            <div class="game-card">
                                <img src="{{ asset('css/assets/game' . $i . '.jpg') }}" alt="Game {{ $i }}">
                            </div>
                        </div>
                    @endfor
                @endforelse
            </div>
            <button class="scroll-btn right" aria-label="Scroll right">›</button>
        </div>
    </section>

    <!-- BROWSE BY CATEGORY SECTION -->
    <section class="browse-category">
        <h2 class="section-title">BROWSE BY CATEGORY</h2>
        <div class="category-list scroll-wrapper">
            <button class="scroll-btn left" aria-label="Scroll left">‹</button>
            <div class="category-list scroll-row">
                @forelse($categories as $category)
                    <div class="category-card" onclick="window.location='{{ route('games.index', ['category' => $category]) }}'">
                        <span>{{ $category }}</span>
                    </div>
                @empty
                    <div class="category-card"><span>Survival</span></div>
                    <div class="category-card"><span>Role-Playing</span></div>
                    <div class="category-card"><span>Action</span></div>
                    <div class="category-card"><span>Casual</span></div>
                    <div class="category-card"><span>Strategy</span></div>
                @endforelse
            </div>
            <button class="scroll-btn right" aria-label="Scroll right">›</button>
        </div>
    </section>

    <!-- GAMES ON SALE SECTION -->
    <section class="games-on-sale">
        <h2 class="section-title">GAMES ON SALE</h2>

        <div class="sale-game-list scroll-wrapper">
            <button class="scroll-btn left" aria-label="Scroll left">‹</button>
            <div class="sale-game-list scroll-row">
            @if($saleGames->count() > 0)
                @foreach($saleGames->take(6) as $index => $game)
                    <div class="sale-game-wrapper" onclick="window.location='{{ route('games.show', $game->id) }}'">
                        <div class="sale-game-card">
                            <img src="{{ $game->poster_url ?: ($game->image_url ?: asset('css/assets/game' . (($index % 5) + 1) . '.jpg')) }}" 
                                 alt="{{ $game->title }}" class="sale-game-poster">
                            <div class="sale-tag"></div>
                        </div>
                    </div>
                @endforeach
            @else
                @for($i = 1; $i <= 6; $i++)
                    <div class="sale-game-wrapper">
                        <div class="sale-game-card">
                            <img src="{{ asset('css/assets/game' . $i . '.jpg') }}" 
                                 alt="Game {{ $i }}" class="sale-game-poster">
                            <div class="sale-tag"></div>
                        </div>
                    </div>
                @endfor
            @endif
            </div>
            <button class="scroll-btn right" aria-label="Scroll right">›</button>
        </div>
    </section>
</main>

<script>
document.querySelectorAll('.preview-box').forEach(box => {
    box.addEventListener('mouseover', () => {
        const bannerImg = document.getElementById('banner-image');
        const bannerPoster = document.getElementById('banner-poster');
        const bannerTitle = document.getElementById('banner-title');

        if (bannerImg && bannerPoster && bannerTitle) {
            // Fade OUT
            [bannerImg, bannerPoster, bannerTitle].forEach(el => el.classList.remove('show'));

            setTimeout(() => {
                // Swap content once fade-out finishes
                bannerImg.src = box.getAttribute('data-banner');
                bannerPoster.src = box.getAttribute('data-poster');
                bannerTitle.textContent = box.getAttribute('data-title');

                // Fade IN
                [bannerImg, bannerPoster, bannerTitle].forEach(el => {
                    setTimeout(() => el.classList.add('show'), 10);
                });
            }, 200);
        }
    });
});

// Set default banner to the first preview
const previews = document.querySelectorAll('.preview-box');
const bannerImg = document.getElementById('banner-image');
const bannerPoster = document.getElementById('banner-poster');
const bannerTitle = document.getElementById('banner-title');

if (previews.length > 0 && bannerImg && bannerPoster && bannerTitle) {
    [bannerImg, bannerPoster, bannerTitle].forEach(el => el.classList.add('fade', 'show'));
    
    // Set initial banner from first preview
    const firstPreview = previews[0];
    if (firstPreview) {
        bannerImg.src = firstPreview.getAttribute('data-banner');
        bannerPoster.src = firstPreview.getAttribute('data-poster');
        bannerTitle.textContent = firstPreview.getAttribute('data-title');
    }
}

// Horizontal scroll controls for sections
function initScrollControls() {
    document.querySelectorAll('.scroll-wrapper').forEach(wrapper => {
        const row = wrapper.querySelector('.scroll-row');
        const btnLeft = wrapper.querySelector('.scroll-btn.left');
        const btnRight = wrapper.querySelector('.scroll-btn.right');

        if (!row || !btnLeft || !btnRight) return;

        const updateBtns = () => {
            btnLeft.disabled = row.scrollLeft <= 0;
            btnRight.disabled = row.scrollLeft + row.clientWidth >= row.scrollWidth - 1;
        };

        // Scroll by 80% of visible width
        const scrollAmount = () => Math.floor(row.clientWidth * 0.8);

        btnLeft.addEventListener('click', () => {
            row.scrollBy({ left: -scrollAmount(), behavior: 'smooth' });
            setTimeout(updateBtns, 300);
        });

        btnRight.addEventListener('click', () => {
            row.scrollBy({ left: scrollAmount(), behavior: 'smooth' });
            setTimeout(updateBtns, 300);
        });

        row.addEventListener('scroll', updateBtns);
        window.addEventListener('resize', updateBtns);
        // initial state
        updateBtns();
    });
}

document.addEventListener('DOMContentLoaded', initScrollControls);
</script>
@endsection
