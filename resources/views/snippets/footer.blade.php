@if (config('custom.google_analytics_code'))
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', '{{config('custom.google_analytics_code')}}', 'auto');
        ga('send', 'pageview');

    </script>
@endif
<footer class="footer">
    <div class="container">
        <div class="content has-text-centered">
            <p>
                <strong>{{ config('app.name') }}</strong> by <a href="http://johnnymast.io">Johnny Mast</a>. The source code is licensed
                <a href="http://opensource.org/licenses/mit-license.php">MIT</a>.
            </p>
            <p>
                <a class="icon" target="_blank" href="//github.com/johnnymast/10min">
                    <i class="fa fa-github"></i>
                </a>
            </p>
        </div>
    </div>
</footer>