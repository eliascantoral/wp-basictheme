        <div class="clear"></div>
    </div>
    <div id="footer" class="container-fluid">
        <div class="container">
            <footer role="contentinfo">
            <div id="copyright">
            <?php echo sprintf( __( '%1$s %2$s %3$s. All Rights Reserved.', 'blankslate' ), '&copy;', date( 'Y' ), esc_html( get_bloginfo( 'name' ) ) ); echo sprintf( __( ' Theme By: %1$s.', 'blankslate' ), '<a href="http://tidythemes.com/">TidyThemes</a>' ); ?>
            </div>
            </footer>        
        </div>
    </div>
</div>
<?php wp_footer(); ?>
</body>
</html>