<?php /** * Template Name: Ajax Shop Page */ get_header();?>
	<div class="container-fluid">
		<div class="row" id="jsProductFilter">
			<div class="col-sm-3" style="border-right:1px solid #ddd">
				<div class="row mt-3">
					<div class="col-sm-12">
            <div class="input-group mb-3">
              <input type="text" class="form-control" id="search" placeholder="Search Products" aria-label="Search Products" aria-describedby="productSearchButton">
              <div class="input-group-append">
                <span class="input-group-text btn bg-primary text-white" id="productSearchButton">Search</span>
              </div>
            </div>
					</div>
				</div>
			</div>
      <div class="col-sm-9">
        <div class="row" id="jsProductItemContainer">
  			</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var $ = jQuery.noConflict();
    $(function(){
      FetchProductData();
    });

    function FetchProductData(){
      $('#jsProductItemContainer').html('Loading products...');
			$.post('<?php echo admin_url('admin-ajax.php'); ?>', {
        cats:[],
				order:null,
				search:$('#search').val(),
        action: "fetch_product_data",
      },function(result){
				RenderProducts(result)
			});
		}

		function RenderProducts(eventData){
			console.log(eventData);
			if (eventData.length < 1){
				$('#jsProductItemContainer').html('<div class="col-sm-12"><h3>No tickets found matching your filter.</h3></div>');
				return;
			}
			var html = '';
			for(a=0;a<eventData.length;a++){
				html += '\
        <div class="col-sm-4 h-100">\
        	<div class="card my-3">\
        		<div class="card-body text-center" style="height:250px">\
            <div style="height:150px; background: url('+eventData[a]["img"]+'); background-size:contain; background-repeat:no-repeat; background-position:center"></div>\
              <h5 class="card-title">'+eventData[a]['title']+'</h5>\
            </div>\
            <div class="card-footer text-center">\
              <div>\
                $'+eventData[a]['price']+'\
              </div>\
              <div>\
							  <a href="'+eventData[a]["url"]+'" class="btn btn-primary">Add To Cart</a>\
              </div>\
					  </div>\
					 </div>\
				</div>';
			}
			$('#jsProductItemContainer').html(html)
		}

		$('#jsProductFilter input').change(function(){
			FetchProductData();
		});

    $('#productSearchButton').click(function(){
      FetchProductData()
    });

    $(window).keydown(function(event){
      if(event.keyCode == 13) {
        event.preventDefault();
        FetchProductData();
        return false;
      }
    });
	</script>
<?php get_footer();?>
