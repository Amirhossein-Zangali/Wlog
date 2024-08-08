<div class="blog_copyright_wrapper">
    <div class="container">
        <div style="text-align: center">
            <p>کپی رایت &copy; 1403 <a href="index.html">Wlog</a>. تمامی حقوق محفوظ است.</p>
        </div>
    </div>
</div>
</div>
<!--Main js file Style-->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/theia-sticky-sidebar.js"></script>
<script src="assets/js/plugins/swiper/swiper.min.js"></script>
<script src="assets/js/plugins/magnific/jquery.magnific-popup.min.js"></script>
<script src="assets/js/wow.min.js"></script>
<script src="assets/js/custom.js"></script>
<script>
    document.querySelectorAll('.has-children span').forEach(item => {
        item.addEventListener('click', function (event) {
            event.preventDefault();
            const parentLi = this.parentElement;
            const dropdown = parentLi.querySelector('.dropdown');

            // Toggle the 'active' class on the parent <li>
            parentLi.classList.toggle('active');

            // Close other open dropdowns
            document.querySelectorAll('.has-children').forEach(li => {
                if (li !== parentLi) {
                    li.classList.remove('active');
                    const otherDropdown = li.querySelector('.dropdown');
                    otherDropdown.style.maxHeight = '0';
                }
            });

            // Toggle max-height for the current dropdown
            if (parentLi.classList.contains('active')) {
                dropdown.style.maxHeight = dropdown.scrollHeight + 'px';
            } else {
                dropdown.style.maxHeight = '0';
            }
        });
    });

</script>
<!--Main js file Style-->
</body>

</html>