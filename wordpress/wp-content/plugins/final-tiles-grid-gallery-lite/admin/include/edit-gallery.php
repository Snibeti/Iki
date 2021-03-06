<?php

if ( !function_exists( 'ftg_p' ) ) {
    function ftg_p( $gallery, $field, $default = NULL )
    {
        global  $ftg_options ;
        
        if ( $ftg_options ) {
            if ( array_key_exists( $field, $ftg_options ) ) {
                print stripslashes( $ftg_options[$field] );
            }
            return;
        }
        
        
        if ( $gallery == NULL || $gallery->{$field} === NULL ) {
            
            if ( $default === NULL ) {
                print "";
            } else {
                print stripslashes( $default );
            }
        
        } else {
            print stripslashes( $gallery->{$field} );
        }
    
    }
    
    function ftg_sel(
        $gallery,
        $field,
        $value,
        $type = "selected"
    )
    {
        global  $ftg_options ;
        
        if ( $ftg_options && $ftg_options[$field] == $value ) {
            print $type;
            return;
        }
        
        
        if ( $gallery == NULL || !isset( $gallery->{$field} ) ) {
            print "";
        } else {
            if ( $gallery->{$field} == $value ) {
                print $type;
            }
        }
    
    }
    
    function ftg_checkFieldDisabled( $options )
    {
        if ( is_array( $options ) && count( $options ) == 3 && $options[2] == "disabled" ) {
            return "disabled";
        }
        return "";
    }
    
    function ftg_checkDisabledOption( $plan )
    {
        return "disabled";
        return "";
    }
    
    function ftg_printPro( $plan )
    {
        return " (upgrade to unlock)";
        return "";
    }
    
    function ftg_printFieldPro( $options )
    {
        if ( is_array( $options ) && count( $options ) == 3 && $options[2] == "disabled" ) {
            return " (upgrade to unlock)";
        }
        return "";
    }

}

global  $ftg_parent_page ;
global  $ftg_fields ;
$filters = array();
//print_r($gallery);
$idx = 0;
function ftgSortByName( $a, $b )
{
    return $a["name"] > $b["name"];
}

?>


<ul class="collapsible" data-collapsible="accordion">
	<?php 
foreach ( $ftg_fields as $section => $s ) {
    ?>
		<li id="<?php 
    _e( FinalTiles_Gallery::slugify( $section ) );
    ?>">
			<div class="collapsible-header">
				<i class="mdi <?php 
    _e( $s["icon"] );
    ?> ftg-section-icon white-text <?php 
    print $colors[$idx];
    ?> darken-2"></i> <?php 
    _e( $section );
    ?>
			</div>
			<div class="collapsible-body <?php 
    print $colors[$idx];
    ?> lighten-5 tab form-fields">
				<div class="jump-head">
					<?php 
    $jumpFields = array();
    foreach ( $s["fields"] as $f => $data ) {
        $jumpFields[$f] = $data;
        $jumpFields[$f]['_code'] = $f;
    }
    unset( $f );
    unset( $data );
    usort( $jumpFields, "ftgSortByName" );
    ?>
					<select class="browser-default jump">
						<option><?php 
    _e( 'Jump to setting', 'final-tiles-gallery' );
    ?></option>
					<?php 
    foreach ( $jumpFields as $f => $data ) {
        ?>
						<?php 
        
        if ( is_array( $data["excludeFrom"] ) && !in_array( $ftg_parent_page, $data["excludeFrom"] ) ) {
            ?>
						<option value="<?php 
            _e( $data['_code'] );
            ?>">
							<?php 
            _e( $data["name"] );
            ?>
						</option>
						<?php 
        }
        
        ?>
					<?php 
    }
    ?>
					</select>

					<?php 
    
    if ( array_key_exists( "presets", $s ) ) {
        ?>
					<select class="browser-default presets" data-field-idx="<?php 
        echo  $idx ;
        ?>">
						<option value="">Select preset</option>
						<?php 
        foreach ( $s["presets"] as $preset => $data ) {
            ?>
						<option><?php 
            echo  $preset ;
            ?></option>
						<?php 
        }
        ?>
					</select>
					<?php 
    }
    
    ?>
				</div>
				<table>
					<tbody>
				<?php 
    foreach ( $s["fields"] as $f => $data ) {
        ?>
					<?php 
        
        if ( is_array( $data["excludeFrom"] ) && !in_array( $ftg_parent_page, $data["excludeFrom"] ) ) {
            ?>
					
					<tr class="row-<?php 
            print $f;
            ?> <?php 
            print $data["type"];
            ?>">						
						<th scope="row">
							<label><?php 
            _e( $data["name"] );
            ?>
								<?php 
            
            if ( $data["mu"] ) {
                ?>
								(<?php 
                _e( $data["mu"] );
                ?>)
								<?php 
            }
            
            ?>
								</label>
						</th>
						<td>
						<div class="field <?php 
            echo  ( in_array( 'shortcode', $data["excludeFrom"] ) ? "" : "js-update-shortcode" ) ;
            ?>">
						<?php 
            
            if ( $data["type"] == "text" ) {
                ?>
							<div class="text">
								<input type="text" size="30" name="ftg_<?php 
                print $f;
                ?>" value="<?php 
                ftg_p( $gallery, $f, $data["default"] );
                ?>" /> 
							</div>
						<?php 
            } elseif ( $data["type"] == "cta" ) {
                ?>
						<div class="text">
							<a class="in-table-cta" href="<?php 
                echo  ftg_fs()->get_upgrade_url() ;
                ?>"><i class="mdi mdi-bell-ring-outline"></i>
            					<?php 
                _e( 'Unlock this feature. Upgrade Now!', 'final-tiles-grid-gallery-lite' );
                ?>
            				</a>
						</div>
						<?php 
            } elseif ( $data["type"] == "select" ) {
                ?>
							<div class="text">
								<select class="browser-default" name="ftg_<?php 
                print $f;
                ?>">
									<?php 
                foreach ( array_keys( $data["values"] ) as $optgroup ) {
                    ?>
										<optgroup label="<?php 
                    print $optgroup;
                    ?>">
											<?php 
                    foreach ( $data["values"][$optgroup] as $option ) {
                        ?>
	
												<?php 
                        $v = explode( "|", $option );
                        ?>
	
												<option <?php 
                        echo  ftg_checkFieldDisabled( $v ) ;
                        ?> <?php 
                        ftg_sel( $gallery, $f, $v[0] );
                        ?> value="<?php 
                        print $v[0];
                        ?>"><?php 
                        print $v[1];
                        echo  ftg_printFieldPro( $v ) ;
                        ?></option>
											<?php 
                    }
                    ?>
										</optgroup>
									<?php 
                }
                ?>
								</select>
								<?php 
                
                if ( $f == "lightbox" ) {
                    ?>
									<div class="col s12 ftg-everlightbox-settings">
									<?php 
                    
                    if ( class_exists( 'Everlightbox_Public' ) ) {
                        ?>
										<div class="card-panel light-green lighten-4">
											<a href="?page=everlightbox_options" target="_blank">EverlightBox settings</a>
										</div>
									<?php 
                    } else {
                        ?>
										<div class="card-panel yellow lighten-3">
											EverlightBox not installed. <a target="_blank" class="open-checkout" href="https://checkout.freemius.com/mode/dialog/plugin/1981/plan/2954/">Purchase</a>
										</div>
									<?php 
                    }
                    
                    ?>								
									</div>
								<?php 
                }
                
                ?>
							</div>
						<?php 
            } elseif ( $data["type"] == "toggle" ) {
                ?>
							<div class="text">
								<input type="checkbox" class="ftg-checkbox" id="ftg_<?php 
                print $f;
                ?>" name="ftg_<?php 
                print $f;
                ?>" value="<?php 
                ftg_p( $gallery, $f, $data["default"] );
                ?>" <?php 
                ftg_sel(
                    $gallery,
                    $f,
                    "T",
                    "checked"
                );
                ?> />
								<label for="ftg_<?php 
                print $f;
                ?>"><?php 
                _e( $data["description"] );
                ?></label>
							</div>

						<?php 
            } elseif ( $data["type"] == "slider" ) {
                ?>
							
							<div class="text">
								<p class="range-field">
							      <input name="ftg_<?php 
                print $f;
                ?>" value="<?php 
                ftg_p( $gallery, $f, $data["default"] );
                ?>" type="range" min="<?php 
                print $data["min"];
                ?>" max="<?php 
                print $data["max"];
                ?>" />
							    </p>
							</div>
							
						<?php 
            } elseif ( $data["type"] == "number" ) {
                ?>
							<div class="text">
								<input type="text" name="ftg_<?php 
                print $f;
                ?>" class="integer-only"  value="<?php 
                ftg_p( $gallery, $f, $data["default"] );
                ?>"  >	
							</div>
								
						<?php 
            } elseif ( $data["type"] == "color" ) {
                ?>
							<div class="text">
							<input type="text" size="6" data-default-color="<?php 
                print $data["default"];
                ?>" name="ftg_<?php 
                print $f;
                ?>" value="<?php 
                ftg_p( $gallery, $f, $data["default"] );
                ?>" class='pickColor' />							</div>

						<?php 
            } elseif ( $data["type"] == "filter" ) {
                ?>

							<div class="filters gallery-filters dynamic-table">
								<div class="text"></div>
								<a href="#" class="add waves-effect waves-light btn">
									<i class="fa fa-plus left"></i> Add filter</a>
                                <p class="reset"><button class="waves-effect waves-light btn yellow reset-default-filter">Reset selected filter</button></p>
								<input type="hidden" name="ftg_filters" value="<?php 
                ftg_p( $gallery, "filters" );
                ?>" />
                                <input type="hidden" name="filter_def" value="<?php 
                ftg_p( $gallery, "defaultFilter" );
                ?>" />
							</div>

						<?php 
            } elseif ( $data["type"] == "textarea" ) {
                ?>
						<div class="text">
							<textarea name="ftg_<?php 
                print $f;
                ?>"><?php 
                ftg_p( $gallery, $f );
                ?></textarea>
						</div>
						<?php 
            } elseif ( $data["type"] == "custom_isf" ) {
                ?>
							<div class="custom_isf dynamic-table">
								<table class="striped">
									<thead>
									<tr>
										<th></th>
										<th><?php 
                _e( 'Resolution', 'final-tiles-gallery' );
                ?> (px)</th>
										<th><?php 
                _e( 'Size factor', 'final-tiles-gallery' );
                ?> (%)</th>
									</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
								<input type="hidden" name="ftg_imageSizeFactorCustom" value="<?php 
                ftg_p( $gallery, "imageSizeFactorCustom" );
                ?>" />
								<a href="#" class="add waves-effect waves-light btn">
									<i class="mdi-content-add left"></i>
									<?php 
                _e( 'Add resolution', 'final-tiles-gallery' );
                ?></a>
							</div>
						<?php 
            }
            
            ?>
						<div class="help">
							<?php 
            
            if ( strlen( $data["description"] ) ) {
                ?>
								<p><?php 
                _e( $data["description"] );
                ?></p>
							<?php 
            }
            
            ?>
							<?php 
            
            if ( !in_array( 'shortcode', $data["excludeFrom"] ) && $data["type"] != "cta" ) {
                ?>
							<div class="ftg-code">
								<a href="#" class="toggle-shortcode" data-code="<?php 
                print $f;
                ?>"><i class="mdi mdi-settings"></i></a>
								<span id="shortcode-<?php 
                print $f;
                ?>">
								Shortcode attribute:
									<input type="text" class="shortcode-val" readonly="" value='<?php 
                _e( FinalTilesGalleryUtils::fieldNameToShortcode( $f ) );
                ?>="<?php 
                ftg_p( $gallery, $f, $data["default"] );
                ?>"'>
								</span>
							</div>
						<?php 
            }
            
            ?>
						</div>

						</div>
						</td>						
						</tr>						
					<?php 
        }
        
        ?>					
				<?php 
    }
    ?>
				</tbody>
				</table>
			</div>
		</li>
		<?php 
    $idx++;
    ?>
	<?php 
}
?>
	<li id="images">
		<div class="collapsible-header">
			<i class="mdi mdi-image-filter ftg-section-icon white-text <?php 
print $colors[$idx];
?> darken-2"></i> <?php 
_e( 'Images', 'final-tiles-gallery' );
?>
		</div>
		<div class="collapsible-body <?php 
print $colors[$idx];
?> lighten-5">
			<div id="images" class="ftg-section form-fields">
				<div class="actions">
					<label><?php 
_e( 'Source:', 'final-tiles-gallery' );
?></label>
					<select name="ftg_source" class="browser-default">
						<option value="images"><?php 
_e( 'User images', 'final-tiles-gallery' );
?></option>
						<option value="posts" <?php 
echo  ftg_checkDisabledOption( 'ultimate' ) ;
?>><?php 
_e( 'Recent posts with featured image', 'final-tiles-gallery' );
echo  ftg_printPro( 'ultimate' ) ;
?></option>
						<?php 

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    ?>
							<option value="woocommerce" <?php 
    echo  ftg_checkDisabledOption( 'ultimate' ) ;
    ?>><?php 
    _e( 'WooCommerce products', 'final-tiles-gallery' );
    echo  ftg_printPro( 'ultimate' ) ;
    ?></option>
						<?php 
}

?>
					</select>
				</div>	
				<div class="actions">
					<div class="row">
						<label>Loading method</label>
						<select name="ftg_loadMethod" class="browser-default">
							<option <?php 
ftg_sel( $gallery, "loadMethod", "sequential" );
?> value="sequential">Sequential</option>
							<option <?php 
ftg_sel( $gallery, "loadMethod", "lazy" );
?> value="lazy">Lazy</option>
						</select>
					</div>
				</div>
				<div class="actions">
					<div class="row">
						<label>Ajax loading</label>
						<select name="ftg_ajaxLoading" class="browser-default js-ajax-loading-control">
							<option <?php 
ftg_sel( $gallery, "ajaxLoading", "F" );
?> value="F">Complete markup on page</option>
							<option <?php 
ftg_sel( $gallery, "ajaxLoading", "T" );
?> value="T">Enable ajax loading (still in beta!)</option>
						</select>
					</div>
					<div class="row js-ajax-loading" style="display:none;">
						<label>Number of images to load via ajax</label>
						<input class="browser-default" type="text" value="<?php 
echo  $gallery->tilesPerPage ;
?>" name="ftg_tilesPerPage">
					</div>
				</div>
				<div class="actions source-images source-panel">
					<div class="row">
						<div class="tips">
				            <span class="shortpixel">
		                  	<img src="<?php 
echo  plugins_url( '', __FILE__ ) ;
?>/../images/icon-shortpixel.png" alt="ShortPixel">
		                  <a target="_blank" href="https://shortpixel.com/wp/af/J4PFT4Z72393"><?php 
_e( 'We suggest you to use ShortPixel image optimization plugin for best SEO results.', 'modula-gallery' );
?></a></span>		            
			            </div>
						<label><?php 
_e( 'Image size', 'final-tiles-gallery' );
?></label>
					
						<select class="current-image-size browser-default">
							<?php 
foreach ( $this->list_thumbnail_sizes() as $size => $atts ) {
    print '<option value="' . $size . '">' . $size . " (" . implode( 'x', $atts ) . ")</option>";
}
?>
						</select>
						 <p class="tips"><?php 
_e( 'Want to add more images sizes?', 'final-tiles-gallery' );
?> <a href="http://www.wpbeginner.com/wp-tutorials/how-to-create-additional-image-sizes-in-wordpress/" target="_blank"><?php 
_e( 'Read a simple tutorial.', 'final-tiles-gallery' );
?></a></p>
						 <div class="tips">
						<strong><?php 
_e( 'About choosing a proper image size:', 'final-tiles-gallery' );
?></strong> <?php 
_e( "Final Tiles Gallery doesn't scale down the images when there's enough space, it gives you the freedom to choose your favourite size for each image. So you should use images that are smaller than the container, choose the", 'final-tiles-gallery' );
?> <strong><?php 
_e( 'thumbnail', 'final-tiles-gallery' );
?></strong> <?php 
_e( 'or', 'final-tiles-gallery' );
?> <strong><?php 
_e( 'medium', 'final-tiles-gallery' );
?></strong> <?php 
_e( 'size, for example.', 'final-tiles-gallery' );
?><br>
						<br>
						<?php 
_e( 'How to get a better grid? Watch the', 'final-tiles-gallery' );
?> <a href="https://www.youtube.com/watch?v=RNT4JGjtyrs" target="_blank"><?php 
_e( 'video tutorial', 'final-tiles-gallery' );
?></a>.
					</div>
					</div>
					<div class="row">
					<a href="#" class="open-media-panel waves-effect waves-light btn action"><i class="mdi mdi-image-area"></i> <?php 
_e( 'Add images', 'final-tiles-gallery' );
?></a>
						<?php 
?>
							<a onclick="alert('Upgrade to unlock')" href="#" class="waves-effect waves-light btn"><i class="mdi mdi-video"></i> <?php 
_e( 'Add video', 'final-tiles-gallery' );
?></a>
						<?php 
?>
					</div>
					<div class="row">
						<p class="tips"><?php 
_e( 'For multiple selections: Click+CTRL.
						Drag images to change order.', 'final-tiles-gallery' );
?></p>
					</div>
				</div>
				<div class="actions source-posts source-panel">					
					<div class="row">
						<label><?php 
_e( 'Image size', 'final-tiles-gallery' );
?></label>
					
						<select class="browser-default" name="ftg_defaultPostImageSize">
							<?php 
foreach ( $this->list_thumbnail_sizes() as $size => $atts ) {
    print '<option ' . (( $size == $gallery->defaultPostImageSize ? 'selected' : '' )) . ' value="' . $size . '">' . $size . " (" . implode( 'x', $atts ) . ")</option>";
}
?>
						</select>
						 <p class="tips"><?php 
_e( 'Want to add more images sizes?', 'final-tiles-gallery' );
?> <a href="http://www.wpbeginner.com/wp-tutorials/how-to-create-additional-image-sizes-in-wordpress/" target="_blank"><?php 
_e( 'Read a simple tutorial.', 'final-tiles-gallery' );
?></a></p>
						 <div class="tips">
						<strong><?php 
_e( 'About choosing a proper image size:', 'final-tiles-gallery' );
?></strong> <?php 
_e( "Final Tiles Gallery doesn't scale down the images\r\n\t\t\t\t\t\twhen there's enough space, it gives you the freedom to choose your favourite size for each image.\r\n\t\t\t\t\t\tSo you should use images that are smaller than the container, choose the", 'final-tiles-gallery' );
?> <strong><?php 
_e( 'thumbnail', 'final-tiles-gallery' );
?></strong> <?php 
_e( 'or', 'final-tiles-gallery' );
?>
						<strong><?php 
_e( 'medium', 'final-tiles-gallery' );
?></strong> <?php 
_e( 'size, for example.', 'final-tiles-gallery' );
?><br>
						<br>
						<?php 
_e( 'How to get a better grid? Watch the', 'final-tiles-gallery' );
?> <a href="https://www.youtube.com/watch?v=RNT4JGjtyrs" target="_blank"><?php 
_e( 'video tutorial', 'final-tiles-gallery' );
?></a>.
					</div>
					<div class="row">
						<label>Taxonomy operator</label>
						<select name="ftg_taxonomyOperator" class="browser-default js-ajax-loading-control">
							<option <?php 
ftg_sel( $gallery, "taxonomyOperator", "OR" );
?> value="OR">OR: all posts matching 1 ore more selected taxonomies</option>
							<option <?php 
ftg_sel( $gallery, "taxonomyOperator", "AND" );
?> value="AND">AND: all posts matching all the selected taxonomies</option>
						</select>
					</div>
					<div class="row">
						<label>Taxonomy as filter</label>
						<select name="ftg_taxonomyAsFilter" class="browser-default js-ajax-loading-control">
							<option></option>
							<?php 
foreach ( get_taxonomies( array(), "objects" ) as $taxonomy => $t ) {
    ?>
								<?php 
    
    if ( $t->publicly_queryable ) {
        ?>								
								<option <?php 
        ftg_sel( $gallery, "taxonomyAsFilter", $t->label );
        ?> value="<?php 
        _e( $t->label );
        ?>"><?php 
        _e( $t->label );
        ?></option>
								<?php 
    }
    
    ?>
							<?php 
}
?>
						</select>						
					</div>
					<div class="row checkboxes">
						<strong class="label"><?php 
_e( 'Post type:', 'final-tiles-gallery' );
?></strong>
							<span>
								<?php 
$idx = 0;
?>
								<?php 
foreach ( get_post_types( '', 'names' ) as $t ) {
    ?>
								<?php 
    
    if ( !in_array( $t, $excluded_post_types ) ) {
        ?>
									<span class="tax-item">
										<input id="post-type-<?php 
        _e( $idx );
        ?>" type="checkbox" name="post_types" value="<?php 
        _e( $t );
        ?>">
										<label for="post-type-<?php 
        _e( $idx );
        ?>"><?php 
        _e( $t );
        ?></label>
									</span>
								<?php 
        $idx++;
        ?>
							<?php 
    }
    
    ?>
								<?php 
}
?>
								<input type="hidden" name="ftg_post_types" value="<?php 
_e( $gallery->post_types );
?>" />
							</span>
					</div>
					<?php 
//print_r(get_taxonomies(array(), "objects")); exit();
?>
					<?php 
foreach ( get_taxonomies( array(), "objects" ) as $taxonomy => $t ) {
    ?>
						<?php 
    
    if ( $t->publicly_queryable ) {
        ?>
							<?php 
        $items = get_terms( $taxonomy, array(
            "hide_empty" => false,
        ) );
        ?>
							<?php 
        
        if ( count( $items ) > 0 ) {
            ?>
							<?php 
            //print_r($items);
            ?>
							<div class="row checkboxes">
								<strong class="label"><?php 
            echo  $t->label ;
            ?></strong>
									<span>
										<?php 
            $idx = 0;
            ?>
										<?php 
            foreach ( $items as $c ) {
                ?>
											<span class="tax-item">
												<input id="post-tax-<?php 
                _e( $c->term_id );
                ?>" type="checkbox" name="post_taxonomy" data-taxonomy="<?php 
                _e( $t->name );
                ?>" value="<?php 
                _e( $c->term_id );
                ?>">
												<label for="post-tax-<?php 
                _e( $c->term_id );
                ?>"><?php 
                _e( $c->name );
                ?></label>
											</span> 
										<?php 
                $idx++;
                ?>
									<?php 
            }
            ?>									
									</span>
							</div>
							<?php 
        }
        
        ?>
						<?php 
    }
    
    ?>
					<?php 
}
?>	
					<input type="hidden" name="ftg_post_taxonomies" value="<?php 
_e( $gallery->post_taxonomies );
?>" />				
					<div class="row checkboxes">
						<strong class="label"><?php 
_e( 'Max posts:', 'final-tiles-gallery' );
?></strong>
						<span class="aside">
							<input type="text" name="ftg_max_posts" value="<?php 
echo  $gallery->max_posts ;
?>">
							<span><?php 
_e( '(enter 0 for unlimited posts)', 'final-tiles-gallery' );
?></span>
						</span>
					</div>					
				</div>
				</div>
				<?php 

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    ?>
				<div class="actions source-woocommerce source-panel">
					<div class="row">
						<label><?php 
    _e( 'Image size', 'final-tiles-gallery' );
    ?></label>
					
						<select class="browser-default" name="ftg_defaultWooImageSize">
							<?php 
    foreach ( $this->list_thumbnail_sizes() as $size => $atts ) {
        print '<option ' . (( $size == $gallery->defaultWooImageSize ? 'selected' : '' )) . ' value="' . $size . '">' . $size . " (" . implode( 'x', $atts ) . ")</option>";
    }
    ?>
						</select>
						 <p class="tips"><?php 
    _e( 'Want to add more images sizes?', 'final-tiles-gallery' );
    ?> <a href="http://www.wpbeginner.com/wp-tutorials/how-to-create-additional-image-sizes-in-wordpress/" target="_blank"><?php 
    _e( 'Read a simple tutorial.', 'final-tiles-gallery' );
    ?></a></p>
						 <div class="tips">
						<strong><?php 
    _e( 'About choosing a proper image size:', 'final-tiles-gallery' );
    ?></strong> <?php 
    _e( "Final Tiles Gallery doesn't scale down the images\r\n\t\t\t\t\t\twhen there's enough space, it gives you the freedom to choose your favourite size for each image.\r\n\t\t\t\t\t\tSo you should use images that are smaller than the container, choose the", 'final-tiles-gallery' );
    ?> <strong><?php 
    _e( 'thumbnail', 'final-tiles-gallery' );
    ?></strong> <?php 
    _e( 'or', 'final-tiles-gallery' );
    ?>
						<strong><?php 
    _e( 'medium', 'final-tiles-gallery' );
    ?></strong> <?php 
    _e( 'size, for example.', 'final-tiles-gallery' );
    ?><br>
						<br>
						<?php 
    _e( 'How to get a better grid? Watch the', 'final-tiles-gallery' );
    ?><a href="https://www.youtube.com/watch?v=RNT4JGjtyrs" target="_blank"><?php 
    _e( 'video tutorial', 'final-tiles-gallery' );
    ?></a>.
					</div>

					<div class="row checkboxes">
						<strong class="label"></strong>
							<span>
								<?php 
    $idx = 0;
    ?>
								<?php 
    foreach ( $woo_categories as $c ) {
        ?>
									<input id="woo-cat-<?php 
        _e( $idx );
        ?>" type="checkbox" name="woo_cat" value="<?php 
        _e( $c->term_id );
        ?>">
									<label for="woo-cat-<?php 
        _e( $idx );
        ?>"><?php 
        _e( $c->cat_name );
        ?></label>
									<?php 
        $idx++;
        ?>									
								<?php 
    }
    ?>
								<input type="hidden" name="ftg_woo_categories" value="<?php 
    _e( $gallery->woo_categories );
    ?>" />
							</span>
					</div>
				</div>
				<?php 
}

?>				
			</div>			
			<div class="actions">
					<div class="bulk row">
						<label><?php 
_e( 'Bulk Actions', 'final-tiles-gallery' );
?></label>
						<div class="options">
							<span class="indigo lighten-4">
								<a class="btn indigo darken-4 waves-effect waves-light" href="#" data-action="select"><?php 
_e( 'Select all', 'final-tiles-gallery' );
?></a>
								<a class="btn indigo darken-4 waves-effect waves-light" href="#" data-action="deselect"><?php 
_e( 'Deselect all', 'final-tiles-gallery' );
?></a>
								<a class="btn indigo darken-4 waves-effect waves-light" href="#" data-action="toggle"><?php 
_e( 'Toggle selection', 'final-tiles-gallery' );
?></a>
							</span>
							<span class="green lighten-4">
								<?php 
?>
								<?php 
?>
							</span>
							<span class="orange lighten-4">
								<a class="btn lime darken-3 waves-effect waves-light" href="#" data-action="show-hide"><?php 
_e( 'Toggle visibility', 'final-tiles-gallery' );
?></a>
								<a class="btn deep-orange darken-1 waves-effect waves-light" href="#" data-action="remove"><?php 
_e( 'Remove', 'final-tiles-gallery' );
?></a>
							</span>
						</div>

						<div class="row">
							<b class="listview"> <?php 
_e( 'List View:', 'final-tiles-gallery' );
?> </b>
							<ul class="list-view-control">
								<li data-size="small" id="listview-small" class="li"> <?php 
_e( 'Small', 'final-tiles-gallery' );
?> </li>
								<li data-size="medium" id="listview-medium" class="li" > <?php 
_e( 'Medium', 'final-tiles-gallery', 'final-tiles-gallery' );
?> </li>
								<li data-size="big" id="listview-big" class="li"> <?php 
_e( 'Big', 'final-tiles-gallery' );
?> </li>
							</ul>
						</div>				

						<div class="panel">
							<strong></strong>
							<p class="text"></p>
							<p class="input">
								<input type="text" placeholder="<?php 
_e( 'Group name', 'final-tiles-gallery' );
?>">
								<span><?php 
_e( 'avoid space and special characters', 'final-tiles-gallery' );
?></span>
							</p>
							<p class="buttons">
								<a class="btn orange cancel" href="#"><?php 
_e( 'Cancel', 'final-tiles-gallery' );
?></a>
								<a class="btn green proceed" href="#"><?php 
_e( 'Proceed', 'final-tiles-gallery' );
?></a>
							</p>
						</div>
					</div>
				</div>

				<?php 

if ( is_array( $filters ) && count( $filters ) > 1 ) {
    ?>
				<div class="row filter-list">
							<b class="listview"> <?php 
    _e( 'Filters:', 'final-tiles-gallery' );
    ?> </b>
							<ul class="filter-select-control">
							<?php 
    foreach ( $filters as $filter ) {
        ?>
								<li class='filter-item' >
								<?php 
        print $filter;
        ?>
								</li>
							<?php 
    }
    ?>
							</ul>
						</div>
				<?php 
}

?>
			<div id="image-list" class="row"></div>		
		</div>
	</li>
</ul>

<a data-tooltip="Update gallery" data-position="top" data-delay="10" class="tooltipped btn-floating btn-large waves-effect waves-light green update-gallery"><i class="fa fa-save"></i></a>

<div class="fixed-action-btn bullet-menu">
    <a class="btn-floating btn-large blue darken-1 right back-to-top">
      <i class="large mdi mdi-chevron-up"></i>
    </a>
    <ul>
	    <?php 
$idx = 0;
?>
	    <?php 
foreach ( $ftg_fields as $section => $s ) {
    ?>
	    <li><a class="btn-floating <?php 
    _e( $colors[$idx++] );
    ?>" rel="<?php 
    _e( FinalTiles_Gallery::slugify( $section ) );
    ?>"><i class="large mdi <?php 
    _e( $s["icon"] );
    ?>"></i></a></li>
	    <?php 
}
?>
	    <li><a class="btn-floating <?php 
_e( $colors[$idx++] );
?>" rel="images"><i class="large mdi mdi-image-filter"></i></a></li>
	</ul>
</div>
  

<!-- video panel -->
<div id="video-panel-model" class="modal">
	<div class="modal-content">
		<p><?php 
_e( 'Paste here the embed code (it must be an ', 'final-tiles-gallery' );
?><strong><?php 
_e( 'iframe', 'final-tiles-gallery' );
?></strong>
			<?php 
_e( 'and it must contain the attributes', 'final-tiles-gallery' );
?> <strong><?php 
_e( 'width', 'final-tiles-gallery' );
?></strong> <?php 
_e( 'and', 'final-tiles-gallery' );
?><strong><?php 
_e( ' height', 'final-tiles-gallery' );
?></strong>)</p>
		<div class="text dark">
			<textarea></textarea>
		</div>
	 <div class="field video-filters clearfix" ></div>
	 <input type="hidden" id="filter-video" value="<?php 
print $gallery->filters;
?>">
	</div>
	<input type="hidden" id="video-panel-action" >
	<div class="field buttons modal-footer">
		<a href="#" data-action="edit" class="action positive save modal-action modal-close waves-effect waves-green btn-flat"><?php 
_e( 'Save', 'final-tiles-gallery' );
?></a>
		<a href="#" data-action="cancel" class="action neutral modal-action modal-close waves-effect waves-yellow btn-flat"><?php 
_e( 'Cancel', 'final-tiles-gallery' );
?></a>
	</div>
</div>



<!-- image panel -->
<div id="image-panel-model"	 class="modal">
	<div class="modal-content cf">
		<h4><?php 
_e( 'Edit image', 'final-tiles-gallery' );
?></h4>
		<div class="left">
			<div class="figure"></div>
			<div class="field sizes"></div>
		</div>
		<div class="right-side">
			<div class="field">
				<label><?php 
_e( 'Title', 'final-tiles-gallery' );
?></label>
				<div class="text">
					<textarea name="imageTitle"></textarea>
				</div>
			</div>
			<div class="field">
				<label><?php 
_e( 'Caption', 'final-tiles-gallery' );
?></label>
				<div class="text">
					<textarea name="description"></textarea>
				</div>
			</div>
			<div class="field">
				<input id="hidden-image" type="checkbox" name="hidden" value="T" />
				<label for="hidden-image">
					<?php 
_e( 'Hidden, visible only with lightbox', 'final-tiles-gallery' );
?>
				</label>
			</div>
				<div class="field js-no-hidden">
				<label><?php 
_e( 'Link', 'final-tiles-gallery' );
?></label>
				<div class="text dark">
					<input type="text" size="20" value="" name="link" />					
				</div>
			</div>
			<div class="field js-no-hidden">
				<label><?php 
_e( 'Link target', 'final-tiles-gallery' );
?></label>
				<div class="text">
					<select name="target" class="browser-default">
						<option value="default"><?php 
_e( 'Default target', 'final-tiles-gallery' );
?></option>
						<option value="_self"><?php 
_e( 'Open in same page', 'final-tiles-gallery' );
?></option>
						<option value="_blank"><?php 
_e( 'Open in _blank', 'final-tiles-gallery' );
?></option>
						<option value="_lightbox"><?php 
_e( 'Open in lightbox (when using a lightbox)', 'final-tiles-gallery' );
?></option>
					</select>
				</div>			
			</div>
			<?php 
?>
		</div>
	</div>	
	<div class="field buttons modal-footer">
		<a href="#" data-action="save" class="action modal-action modal-close waves-effect waves-green btn-flat"><i class="fa fa-save"></i> <?php 
_e( 'Save', 'final-tiles-gallery' );
?></a>
		<a href="#" data-action="cancel" class="action modal-action modal-close waves-effect waves-yellow btn-flat"><i class="mdi-content-reply"></i> <?php 
_e( 'Cancel', 'final-tiles-gallery' );
?></a>
	</div>
</div>

<div class="preloader-wrapper big active" id="spinner">
    <div class="spinner-layer spinner-blue-only">
      <div class="circle-clipper left">
        <div class="circle"></div>
      </div><div class="gap-patch">
        <div class="circle"></div>
      </div><div class="circle-clipper right">
        <div class="circle"></div>
      </div>
    </div>
  </div>
<!-- images section -->

<div class="overlay" style="display:none"></div>

<script>
	var presets = {};
	<?php 
$presetIdx = 0;
foreach ( $ftg_fields as $section => $s ) {
    if ( array_key_exists( "presets", $s ) ) {
        foreach ( $s["presets"] as $preset => $values ) {
            echo  "presets['preset_" . $presetIdx . "_" . $preset . "'] = " . json_encode( $values ) . ";\n" ;
        }
    }
    $presetIdx++;
}
?>

	var ftg_wp_caption_field = '<?php 
ftg_p( $gallery, "wp_field_caption" );
?>';
	(function ($) {
		$("[name=captionFullHeight]").change(function () {
			if($(this).val() == "F")
				$("[name=captionEffect]").val("fade");
		});
		$("[name=captionEffect]").change(function () {
			if($(this).val() != "fade" && $("[name=captionFullHeight]").val() == "F") {
				$(this).val("fade");
				alert("Cannot set this effect if 'Caption full height' is switched off.");
			}
		});
		
		<?php 
?>

	})(jQuery);
</script>
