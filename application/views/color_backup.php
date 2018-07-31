<div class="l-b-filter"></div>

							<div class="break-color checkboxs">
								<div class="b-title"><b>Color</b><a href="#" class="remove">Hapus Filter</a></div>
								
								<div class="scroll-box-color">
									<ul class="media-list color">
										<?php
											foreach ($color AS $cl) {
										?>
										<li class="media checkbox">
											<a href="#">
												<span class="box-color" style="background-color:<?php echo $cl->color_code;?>" title="<?php echo $cl->color_name;?>"></span>
												<div class="hovered"><i class="fa fa-check"></i></div> <!-- active = class="color-active" -->
											</a>
										</li>	
										<?php } ?>
									</ul>
								</div>
							</div> <!-- //color -->




							<div class="l-b-filter"></div>

							<div class="break-color checkboxs">
								<div class="b-title"><b>Color</b><a href="#" class="remove">Hapus Filter</a></div>
								
								<div class="scroll-box-color">
									<ul class="media-list color">
										<?php
											foreach ($color AS $cl) {
										?>
										<li class="media checkbox">
											<a href="#">
												<span class="box-color" style="background-color:<?php echo $cl->color_code;?>" title="<?php echo $cl->color_name;?>"></span>
												<div class="hovered"><i class="fa fa-check"></i></div> <!-- active = class="color-active" -->
											</a>
										</li>	
										<?php } ?>
									</ul>
								</div>
							</div> <!-- //color -->