(function($) {
    $(document).ready(function(){
		// bxslider
		$('.product-slide').bxSlider({
			slideMargin: 0,
			autoReload: true,
			pager: false,
			auto: true,
			speed: 800,
			moveSlides: 1,
			breaks: [
				{screen:0, slides:2},
				{screen:460, slides:3},
				{screen:768, slides:3},
				{screen:992, slides:4},
				{screen:1024, slides:5}
			]
		});
		
		$('.product-similar').bxSlider({
			slideMargin: 15,
			autoReload: true,
			pager: false,
			interval: 1000,
			auto: false,
			speed: 800,
			moveSlides: 1,
			breaks: [
				{screen:0, slides:2},
				{screen:460, slides:3},
				{screen:768, slides:4},
				{screen:992, slides:5}
			]
		});
		
		// plugin bootstrap minus and plus for qty
		$('.btn-number').click(function(e){
			e.preventDefault();
			
			fieldName = $(this).attr('data-field');
			type      = $(this).attr('data-type');
			var input = $("input[name='"+fieldName+"']");
			var currentVal = parseInt(input.val());
			if (!isNaN(currentVal)) {
				if(type == 'minus') {
					
					if(currentVal > input.attr('min')) {
						input.val(currentVal - 1).change();
					} 
					if(parseInt(input.val()) == input.attr('min')) {
						$(this).attr('disabled', true);
					}

				} else if(type == 'plus') {

					if(currentVal < input.attr('max')) {
						input.val(currentVal + 1).change();
					}
					if(parseInt(input.val()) == input.attr('max')) {
						$(this).attr('disabled', true);
					}

				}
			} else {
				input.val(0);
			}
		});
	
		$('.input-number').focusin(function(){
			$(this).data('oldValue', $(this).val());
		});
	
		$('.input-number').change(function() {
			
			minValue =  parseInt($(this).attr('min'));
			maxValue =  parseInt($(this).attr('max'));
			valueCurrent = parseInt($(this).val());
			
			name = $(this).attr('name');
			if(valueCurrent >= minValue) {
				$(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
			} else {
				alert('Sorry, the minimum value was reached');
				$(this).val($(this).data('oldValue'));
			}
			if(valueCurrent <= maxValue) {
				$(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
			} else {
				alert('Sorry, the maximum value was reached');
				$(this).val($(this).data('oldValue'));
			}
			
			
		});
	
		$(".input-number").keydown(function (e) {
			// Allow: backspace, delete, tab, escape, enter and .
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
				// Allow: Ctrl+A
				(e.keyCode == 65 && e.ctrlKey === true) || 
				// Allow: home, end, left, right
				(e.keyCode >= 35 && e.keyCode <= 39)) {
					// let it happen, don't do anything
					return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
		
		// same height
		$('.same-height').responsiveEqualHeightGrid();
		
		// avoid hide dropdown on click
		$('.dropdown-menu').click(function(event){
			event.stopPropagation();
		});

		// avoid auto slide
		$('.carousel').carousel({
			interval: false,
			// auto: true,
			// speed: 8000
		});
		
		// zoom image
		$('.zoo-item').ZooMove({
			cursor: 'true',
			scale: '1.2',
		});

		// change window size for dropdown
		if($(window).width() >= 768) {
            $('nav .dropdown').hover(function() {
				$(this).find('.dropdown-menu').stop(true, true).delay(10).fadeIn(10);
			}, function() {
				$(this).find('.dropdown-menu').stop(true, true).delay(10).fadeOut(10);
			});
			
			$('.shop-menu > a').click(false);
        };
		
		if($(window).width() >= 768) {
			$(window).scroll(function(){
				if ($(this).scrollTop() > 50) {
					$("#filter").addClass('fixeded').stop(true, true).delay(50).fadeIn(50);
					$("#filter").removeClass('fixeded-top').stop(true, true).delay(50).fadeIn(50);
				} else {
					$("#filter").removeClass('fixeded');
					$("#filter").addClass('fixeded-top');
				}
			});
			
			$("#filter").pin({containerSelector: ".content"});
			
			$(window).scroll(function(){
				if ($(this).scrollTop() > 100) {
					$("#filter").pin({padding: {top: 80, bottom: 600}});
				} else {
					$("#filter").pin({padding: {top: 80, bottom: 600}});
				}
			});
		};

	});
	
	$(document).ready(function() {
	    $('#myCarousel').carousel({
			interval: 1000
		})
	    
	    $('#myCarousel').on('slid.bs.carousel', function() {
	    	//alert("slid");
		});
	    
	    
	});
})(jQuery);