<div class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <a href="{{ Helper::getAdUrl('leader_board') }}">
                <img src="{{ Helper::getAd('leader_board') }}" class="img ad">
            </a>
        </div>
        @if (Helper::hasAd('leader_board_2'))
            <div class="carousel-item">
                <a href="{{ Helper::getAdUrl('leader_board_2') }}">
                    <img src="{{ Helper::getAd('leader_board_2') }}" class="img ad">
                </a>
            </div>
        @endif
        @if (Helper::hasAd('leader_board_3'))
            <div class="carousel-item">
                <a href="{{ Helper::getAdUrl('leader_board_3') }}">
                    <img src="{{ Helper::getAd('leader_board_3') }}" class="img ad">
                </a>
            </div>
        @endif
        @if (Helper::hasAd('leader_board_4'))
            <div class="carousel-item">
                <a href="{{ Helper::getAdUrl('leader_board_4') }}">
                    <img src="{{ Helper::getAd('leader_board_4') }}" class="img ad">
                </a>
            </div>
        @endif
    </div>
</div>
