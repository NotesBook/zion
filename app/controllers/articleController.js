nbApp.controller('ArticleController', ['$scope','ArticlesService','ValidationService','SharedDataService','UserService',
	function($scope,ArticlesService,ValidationService,SharedDataService,UserService) {

		$scope.show_text = false;

		// Get the classroom object recived from dashboard
        $scope.classroom_item = SharedDataService.get_val();

		// ArticlesService.get_classroom_articles('GET',"api/classroom/last_articles",$scope.classroom_item.id).then(function(response) {
		// 	$scope.classroom_articles = response.data;
		// 	});	        

		// Get logged in user data
		UserService.get_logged_user_data().then(function(response) {
			$scope.logged_user_data = response.data;
		});

		$scope.article_form_data = {
			"classroom_id": "",
			"user_id": "",
			"title": "",
			"body": "",
			"tags": "",
			"topic": ""
		};

        // Get validation JSON  Object
        ValidationService.getValidationJSON().then(function(response) {

            $scope.JSON_validation = response; 

        });		

		$scope.edit_article = function(article_content) {

			$scope.text_box_content = article_content;
			
		};

		$scope.empty_text_box = function() {
			$scope.text_box_content = ""
		};

        ArticlesService.get_last_articles("GET","api/classroom/last_articles/"+$scope.classroom_item.id).then(function(response) {

            $scope.last_classroom_articles = response.data;

        });


		// Refresh the classroom side list when classroom is created
		$scope.refresh_articles = function() {

			ArticlesService.get_classroom_articles('GET',"api/classroom/last_articles",$scope.classroom_item.id).then(function(response) {
			$scope.classroom_articles = response.data;
			});
		};		

        // Send the form input data to process it at backend
        $scope.send_article_form_data = function() {
        	

        	$scope.article_form_data['classroom_id'] = $scope.classroom_item.id;

        	$scope.article_form_data['user_id'] = $scope.logged_user_data.id

            ArticlesService.create_article('POST','api/article/save',JSON.stringify($scope.article_form_data)).then(function(response) {

                if(response.valid == true) {

                    document.getElementById('valid-article-modal').style.display='block';
                    document.getElementById('article-modal').style.display='none';
            
                } else $scope.show_valid_modal = false;
 
            });
        };     

        // Hides the valid modal when accept button is clicked 
        $scope.hide_valid_article_form = function() {
                
             document.getElementById('valid-article-modal').style.display='none';
        };		

}])