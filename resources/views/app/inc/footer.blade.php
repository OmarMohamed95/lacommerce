<div class="footer">
    <p class="col-md-offset-5">(c) Developed by OMAR MOHAMED</p>
    @if ($sitting)
        <a href="{{ $sitting->fb }}" target="_blank"><i class="fab fa-facebook-square fa-2x"></i></a>
        <a href="{{ $sitting->tw }}" target="_blank"><i class="fab fa-twitter-square fa-2x"></i></a>
        <a href="{{ $sitting->yt }}" target="_blank"><i class="fab fa-youtube-square fa-2x"></i></a>
    @endif
</div>