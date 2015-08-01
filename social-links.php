<?php 
    $social_options = get_option('social_settings');
    if (isset($social_options)) :
?>
    <div class="social-media hide-for-small-only">
        <ul class="inline-list">
            <?php if ( isset($social_options['facebook']) ) : ?><li><a href="http://<?php echo $social_options['facebook']; ?>"><i class="fa fa-facebook"></i></a></li><?php endif; ?>
            <?php if ( isset($social_options['twitter']) ) : ?><li><a href="http://<?php echo $social_options['twitter']; ?>"><i class="fa fa-twitter"></i></a></li><?php endif; ?>
            <?php if ( isset($social_options['google_plus']) ) : ?><li><a href="http://<?php echo $social_options['google_plus']; ?>"><i class="fa fa-google-plus"></i></a></li><?php endif; ?>
            <?php if ( isset($social_options['instagram']) ) : ?><li><a href="http://<?php echo $social_options['instagram']; ?>"><i class="fa fa-instagram"></i></a></li><?php endif; ?>
            <?php if ( isset($social_options['pinrest']) ) : ?><li><a href="http://<?php echo $social_options['pinrest']; ?>"><i class="fa fa-pinterest-p"></i></a></li><?php endif; ?>
        </ul>
    </div>

<?php 
    endif; 
?>