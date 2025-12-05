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
                    $displayFeaturedGames = isset($featuredGames) && $featuredGames->count() > 0 ? $featuredGames->take(6) : (isset($popularGames) && $popularGames->count() > 0 ? $popularGames->take(6) : collect());
                    $firstGame = $displayFeaturedGames->first();

                    // Helper function to get banner placeholder path
                    $getBannerPath = function ($num) {
                        $extensions = ['', '2.jpg', '3.webp', '4.webp', '5.jpg', '6.jpg', '7.jpg', '8.jpg', '9.jpg', '10.jpg'];
                        $ext = $extensions[$num - 1] ?? '.jpg';
                        return asset('css/assets/gamebanner_placeholder' . $ext);
                    };

                    // Helper function to get poster path
                    $getPosterPath = function ($num) {
                        $extensions = ['.jpg', '.jpg', '.jpg', '.jpg', '.png', '.jpg', '.jpg', '.jpg', '.jpg', '.jpg'];
                        $ext = $extensions[$num - 1] ?? '.jpg';
                        return asset('css/assets/game' . $num . $ext);
                    };

                    // Determine banner and poster images
                    // Banner should use banner placeholder, poster uses game image
                    if ($firstGame) {
                        // Find which game number this is to get the correct banner
                        // Switch banners: Elden Ring uses banner 2, Silent Hill f uses banner 5
                        $bannerMapping = [
                            'Elden Ring' => 2,           // Switched: uses banner 2
                            'Silent Hill f' => 5,        // Uses banner 5
                            'Hollow Knight: Silksong' => 3,
                            'Baldur\'s Gate 3' => 4,
                            'The Elder Scrolls V: Skyrim' => 9
                        ];

                        $gameNum = $bannerMapping[$firstGame->title] ?? 1;

                        $consoleIcon = asset('css/assets/console_icon.jpg');
                        $bannerImage = $getBannerPath($gameNum);
                        $posterImage = !empty($firstGame->image_url) ? $firstGame->image_url : $consoleIcon;
                        $gameTitle = $firstGame->title;
                    } else {
                        $consoleIcon = asset('css/assets/console_icon.jpg');
                        $bannerImage = $getBannerPath(1);
                        $posterImage = $consoleIcon;
                        $gameTitle = 'Featured Game';
                    }
                @endphp

                <img id="banner-image" class="banner-img" src="{{ $bannerImage }}" alt="{{ $gameTitle }}"
                    onerror="this.onerror=null; this.src='{{ $getBannerPath(1) }}';">

                <!-- Overlay Box -->
                <div class="banner-overlay">
                    @php
                        $firstGameId = $firstGame ? $firstGame->id : null;
                    @endphp
                    @php
                        $consoleIcon = asset('css/assets/console_icon.jpg');
                    @endphp
                    <img id="banner-poster" class="banner-poster" src="{{ $posterImage }}" alt="{{ $gameTitle }}"
                        onerror="this.onerror=null; this.src='{{ $consoleIcon }}';"
                        @if($firstGameId) onclick="window.location='{{ route('games.show', $firstGameId) }}'" style="cursor: pointer;" @endif>
                    <h3 id="banner-title" class="banner-title">{{ $gameTitle }}</h3>
                </div>
            </div>

            <!-- PREVIEW THUMBNAILS -->
            <div class="preview-row">
                @php
                    // Helper function to get banner placeholder path with correct extension
                    $getBannerPath = function ($num) {
                        $extensions = ['', '2.jpg', '3.webp', '4.webp', '5.jpg', '6.jpg', '7.jpg', '8.jpg', '9.jpg', '10.jpg'];
                        $ext = $extensions[$num - 1] ?? '.jpg';
                        return asset('css/assets/gamebanner_placeholder' . $ext);
                    };

                    // Helper function to get poster path with correct extension
                    $getPosterPath = function ($num) {
                        $extensions = ['.jpg', '.jpg', '.jpg', '.jpg', '.png', '.jpg', '.jpg', '.jpg', '.jpg', '.jpg'];
                        $ext = $extensions[$num - 1] ?? '.jpg';
                        return asset('css/assets/game' . $num . $ext);
                    };
                @endphp

                @php
                    // Always show 5 preview boxes using all available game images
                    $totalGameImages = 5;

                    // Get the 5 featured games by title (matching our placeholder games)
                    $featuredGameTitles = [
                        'Elden Ring',
                        'Silent Hill f',
                        'Hollow Knight: Silksong',
                        'Baldur\'s Gate 3',
                        'The Elder Scrolls V: Skyrim'
                    ];

                    // Fetch games by title, or use placeholders
                    $gamesToShow = [];
                    foreach ($featuredGameTitles as $index => $title) {
                        $game = \App\Models\Game::where('title', $title)->first();
                        if ($game) {
                            $gamesToShow[] = $game;
                        } else {
                            // Create a placeholder game object
                            $gamesToShow[] = (object) [
                                'title' => $title,
                                'image_url' => null
                            ];
                        }
                    }
                @endphp
                @foreach($gamesToShow as $index => $game)
                    @php
                        // Switch banners: Elden Ring uses banner 2, Silent Hill f uses banner 5
                        $bannerMapping = [
                            'Elden Ring' => 2,           // Switched: uses banner 2
                            'Silent Hill f' => 5,        // Uses banner 5
                            'Hollow Knight: Silksong' => 3,
                            'Baldur\'s Gate 3' => 4,
                            'The Elder Scrolls V: Skyrim' => 9
                        ];

                        $bannerNum = $bannerMapping[$game->title] ?? ($index + 1);
                        $posterNum = $index + 1;

                        $bannerPlaceholder = $getBannerPath($bannerNum);
                        $posterPlaceholder = $getPosterPath($posterNum);

                        // Banner always uses banner placeholder, poster uses game image or console icon
                        $consoleIcon = asset('css/assets/console_icon.jpg');
                        $bannerImage = $bannerPlaceholder;
                        $posterImage = !empty($game->image_url) ? $game->image_url : $consoleIcon;
                        $gameTitle = $game->title;
                        $gameId = $game->id ?? null;
                    @endphp
                    <div class="preview-box" data-banner="{{ $bannerImage }}" data-poster="{{ $posterImage }}"
                        data-title="{{ $gameTitle }}" data-game-id="{{ $gameId }}"
                        style="background-image: url('{{ $posterImage }}'); background-size: cover; background-position: center; display: block !important; visibility: visible !important; opacity: 0.7;">
                    </div>
                @endforeach
            </div>
        </section>

        <!-- POPULAR GAMES SECTION -->
        <section class="popular-games">
            <h2 class="section-title">POPULAR GAMES</h2>

            <div class="games-container scroll-wrapper">
                <button class="scroll-btn left" aria-label="Scroll left">‹</button>
                <div class="games-list scroll-row">
                    @php
                        // Helper function to get poster path with correct extension
                        $getPosterPath = function ($num) {
                            $extensions = ['.jpg', '.jpg', '.jpg', '.jpg', '.png', '.jpg', '.jpg', '.jpg', '.jpg', '.jpg'];
                            $ext = $extensions[$num - 1] ?? '.jpg';
                            return asset('css/assets/game' . $num . $ext);
                        };
                    @endphp
                    @forelse($popularGames->take(6) as $index => $game)
                        @php
                            $consoleIcon = asset('css/assets/console_icon.jpg');
                            $posterImage = !empty($game->image_url) ? $game->image_url : $consoleIcon;
                        @endphp
                        <div class="game-card-wrapper" onclick="window.location='{{ route('games.show', $game->id) }}'">
                            <div class="game-card">
                                <img src="{{ $posterImage }}" alt="{{ $game->title }}"
                                    onerror="this.onerror=null; this.src='{{ $consoleIcon }}';">
                            </div>
                        </div>
                    @empty
                        @php
                            $consoleIcon = asset('css/assets/console_icon.jpg');
                        @endphp
                        @for($i = 1; $i <= 6; $i++)
                            <div class="game-card-wrapper">
                                <div class="game-card">
                                    <img src="{{ $consoleIcon }}" alt="Game {{ $i }}"
                                        onerror="this.onerror=null; this.src='{{ $consoleIcon }}';">
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
            <div class="category-wrapper scroll-wrapper">
                <button class="scroll-btn left" aria-label="Scroll left">‹</button>
                <div class="category-list scroll-row">
                    @forelse($categories as $category)
                        <div class="category-card"
                            onclick="window.location='{{ route('games.index', ['category' => $category]) }}'">
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

            <div class="sale-game-wrapper-container scroll-wrapper">
                <button class="scroll-btn left" aria-label="Scroll left">‹</button>
                <div class="sale-game-list scroll-row">
                    @php
                        // Helper function to get poster path with correct extension
                        $getPosterPath = function ($num) {
                            $extensions = ['.jpg', '.jpg', '.jpg', '.jpg', '.png', '.jpg', '.jpg', '.jpg', '.jpg', '.jpg'];
                            $ext = $extensions[$num - 1] ?? '.jpg';
                            return asset('css/assets/game' . $num . $ext);
                        };
                    @endphp
                    @if($saleGames->count() > 0)
                        @foreach($saleGames->take(6) as $index => $game)
                            @php
                                $consoleIcon = asset('css/assets/console_icon.jpg');
                                $posterImage = !empty($game->image_url) ? $game->image_url : $consoleIcon;
                            @endphp
                            <div class="sale-game-wrapper" onclick="window.location='{{ route('games.show', $game->id) }}'">
                                <div class="sale-game-card">
                                    <img src="{{ $posterImage }}" alt="{{ $game->title }}" class="sale-game-poster"
                                        onerror="this.onerror=null; this.src='{{ $consoleIcon }}';">
                                    <div class="sale-tag"></div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        @php
                            $consoleIcon = asset('css/assets/console_icon.jpg');
                        @endphp
                        @for($i = 1; $i <= 6; $i++)
                            <div class="sale-game-wrapper">
                                <div class="sale-game-card">
                                    <img src="{{ $consoleIcon }}" alt="Game {{ $i }}" class="sale-game-poster"
                                        onerror="this.onerror=null; this.src='{{ $consoleIcon }}';">
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
                    // Get new values
                    const newBanner = box.getAttribute('data-banner');
                    const newPoster = box.getAttribute('data-poster');
                    const newTitle = box.getAttribute('data-title');
                    const newGameId = box.getAttribute('data-game-id');

                    // Fade OUT
                    [bannerImg, bannerPoster, bannerTitle].forEach(el => {
                        el.style.opacity = '0';
                    });

                    setTimeout(() => {
                        // Swap content once fade-out finishes
                        if (newBanner) bannerImg.src = newBanner;
                        if (newPoster) bannerPoster.src = newPoster;
                        if (newTitle) bannerTitle.textContent = newTitle;
                        
                        // Update click handler for poster image
                        if (newGameId) {
                            bannerPoster.style.cursor = 'pointer';
                            bannerPoster.onclick = function() {
                                window.location.href = '/games/' + newGameId;
                            };
                        } else {
                            bannerPoster.style.cursor = 'default';
                            bannerPoster.onclick = null;
                        }

                        // Fade IN
                        setTimeout(() => {
                            [bannerImg, bannerPoster, bannerTitle].forEach(el => {
                                el.style.opacity = '1';
                            });
                        }, 50);
                    }, 200);
                }
            });
        });

        // Set default banner to the first preview and ensure visibility
        const previews = document.querySelectorAll('.preview-box');
        const bannerImg = document.getElementById('banner-image');
        const bannerPoster = document.getElementById('banner-poster');
        const bannerTitle = document.getElementById('banner-title');

        if (previews.length > 0 && bannerImg && bannerPoster && bannerTitle) {
            // Set initial banner from first preview
            const firstPreview = previews[0];
            if (firstPreview) {
                const initialBanner = firstPreview.getAttribute('data-banner');
                const initialPoster = firstPreview.getAttribute('data-poster');
                const initialTitle = firstPreview.getAttribute('data-title');
                const initialGameId = firstPreview.getAttribute('data-game-id');

                if (initialBanner) bannerImg.src = initialBanner;
                if (initialPoster) bannerPoster.src = initialPoster;
                if (initialTitle) bannerTitle.textContent = initialTitle;
                
                // Set click handler for poster image
                if (initialGameId && bannerPoster) {
                    bannerPoster.style.cursor = 'pointer';
                    bannerPoster.onclick = function() {
                        window.location.href = '/games/' + initialGameId;
                    };
                }
            }

            // Ensure all elements are visible
            [bannerImg, bannerPoster, bannerTitle].forEach(el => {
                el.style.opacity = '1';
                el.style.display = 'block';
            });
        }

        // Horizontal scroll controls for sections
        function initScrollControls() {
            document.querySelectorAll('.scroll-wrapper').forEach(wrapper => {
                // Try to find scroll-row, games-list, or category-list
                let row = wrapper.querySelector('.scroll-row');

                // If no scroll-row, try other selectors
                if (!row) {
                    row = wrapper.querySelector('.games-list');
                }
                if (!row) {
                    row = wrapper.querySelector('.category-list');
                }
                if (!row) {
                    row = wrapper.querySelector('.sale-game-list');
                }

                const btnLeft = wrapper.querySelector('.scroll-btn.left');
                const btnRight = wrapper.querySelector('.scroll-btn.right');

                if (!row || !btnLeft || !btnRight) {
                    console.log('Scroll controls not found:', {
                        row: !!row,
                        btnLeft: !!btnLeft,
                        btnRight: !!btnRight,
                        wrapper: wrapper.className
                    });
                    return;
                }

                // Ensure row is scrollable
                if (row.style.overflowX !== 'hidden') {
                    row.style.overflowX = 'auto';
                }

                const updateBtns = () => {
                    const scrollLeft = row.scrollLeft;
                    const scrollWidth = row.scrollWidth;
                    const clientWidth = row.clientWidth;

                    const isAtStart = scrollLeft <= 5;
                    const isAtEnd = scrollLeft + clientWidth >= scrollWidth - 5;

                    btnLeft.disabled = isAtStart;
                    btnRight.disabled = isAtEnd;

                    btnLeft.style.opacity = isAtStart ? '0.3' : '1';
                    btnRight.style.opacity = isAtEnd ? '0.3' : '1';
                    btnLeft.style.cursor = isAtStart ? 'not-allowed' : 'pointer';
                    btnRight.style.cursor = isAtEnd ? 'not-allowed' : 'pointer';
                };

                // Scroll by 80% of visible width
                const scrollAmount = () => Math.floor(row.clientWidth * 0.8);

                // Remove any existing listeners by cloning
                const newBtnLeft = btnLeft.cloneNode(true);
                const newBtnRight = btnRight.cloneNode(true);
                btnLeft.parentNode.replaceChild(newBtnLeft, btnLeft);
                btnRight.parentNode.replaceChild(newBtnRight, btnRight);

                // Add click handlers to new buttons
                newBtnLeft.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    const amount = scrollAmount();
                    row.scrollBy({ left: -amount, behavior: 'smooth' });
                    setTimeout(updateBtns, 300);
                });

                newBtnRight.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    const amount = scrollAmount();
                    row.scrollBy({ left: amount, behavior: 'smooth' });
                    setTimeout(updateBtns, 300);
                });

                row.addEventListener('scroll', updateBtns);
                window.addEventListener('resize', updateBtns);

                // Initial state - wait a bit for layout
                setTimeout(updateBtns, 200);
            });
        }

        document.addEventListener('DOMContentLoaded', initScrollControls);
    </script>
@endsection