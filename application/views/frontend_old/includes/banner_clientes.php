        <div id="slide-show">
            <div id="wrapper">
                <div class="slider-wrapper theme-default">
                    <div class="ribbon"></div>
                    <div id="slider" class="nivoSlider">
                    <?php

                    foreach ($banners as $key => $value) {
                        ?>
                        <img src="files/banner_clientes/<?php echo $value->imagen;?>" border="0" title="<?php echo $value->titulo;?>"/>
                        <?php					
                    }
                    ?>                            
                    </div>
                </div>
            </div>          
        </div>