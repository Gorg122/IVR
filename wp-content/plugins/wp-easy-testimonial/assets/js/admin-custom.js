(function($){
	/*$(document).ready(function(){
		$(document).find('input[id*="wtclientrate"]').on('click',function(){
			
			$('input[id*="wtclientrate"]')
			
			var input = $(this);
			var value = input.attr("value");
			var newimgname = 'star'+ value;
			
			var img = input.next("img");
			var src = img.attr('src');
			
			// befor new image insert
			$('input[id*="wtclientrate"]').next("img").prop("src",src);
			
			// getting img name
			var imgdata   =	img.attr('src').split('.');
			var imgname = imgdata[0].split('/');
				imgname = imgname[imgname.length-1];
				
				// replace with new image
				src = src.replace(imgname,newimgname);
				img.prop("src",src);
		});
	});*/
})(jQuery);