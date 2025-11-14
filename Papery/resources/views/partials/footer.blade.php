<button id="backToTop" class="back-to-top">
    <svg class="progress-ring" width="50" height="50">
        <circle class="progress-ring__circle" stroke-width="2" fill="transparent" r="22" cx="25" cy="25"/>
    </svg>
    <i class="fas fa-arrow-up"></i>
</button>

<footer class="footer">
    <div class="footer-content container">

        <!-- หมวดหมู่ -->
        <div class="footer-links">
            <h5>หมวดหมู่</h5>
            <nav class="categories">
                <a href="{{ route('home.category', 'cartoon') }}">การ์ตูน</a>
                <a href="{{ route('home.category', 'fiction') }}">นิยาย/วรรณกรรม</a>
                <a href="{{ route('home.category', 'travel') }}">ท่องเที่ยว</a>
                <a href="{{ route('home.category', 'psychology') }}">จิตวิทยา</a>
                <a href="{{ route('home.category', 'knowledge') }}">ความรู้ทั่วไป</a>
            </nav>
        </div>

        <!-- Social -->
        <div class="footer-newsletter">
            <div class="social-icons">
                <a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
                <a href="https://x.com/"><i class="fab fa-twitter"></i></a>
                <a href="https://www.youtube.com/"><i class="fab fa-youtube"></i></a>
                <a href="https://www.linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>©2025 Papery All rights reserved</p>
    </div>
</footer>
