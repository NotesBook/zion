nbApp.controller('ArticleController', ['$scope','ArticlesService',
	function($scope,ArticlesService) {

		$scope.show_text = false;

		$scope.edit_article = function(article_content) {

			$scope.text_box_content = article_content;
				

		}

		$scope.empty_text_box = function() {
			$scope.text_box_content = ""
		}

        // ArticleService.get_last_articles("GET","api/dashboard/last_articles","").then(function(response) {
        
        //     $scope.last_articles = response;

        // });

		// $scope.articles = [
		// 	{ 
		// 		id: 1,
		// 		nombre: "Articulo 1", 
		// 		respuestas: [{ respuesta: "Respuesta 1"}, {respuesta: "Respuesta 2"}, {respuesta: "Respuesta 3"}],
		// 		comentario: "Comentarios", 
		// 		contenido: "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum." 
		// 	},
		// 	{ 
		// 		id: 2,
		// 		nombre:"Articulo 2",
		// 		respuestas: [{ respuesta: "Respuesta 1"}, {respuesta: "Respuesta 2"}, {respuesta: "Respuesta 3"}], 
		// 		comentario: "Comentarios",
		// 		contenido: "Contenido 2" 
		// 	},
		// 	{ 
		// 		id: 3,
		// 		nombre:"Articulo 3",
		// 		respuestas: [{ respuesta: "Respuesta 1"}, {respuesta: "Respuesta 2"}, {respuesta: "Respuesta 3"}], 
		// 		comentario: "Comentarios", 
		// 		contenido: "Contenido 3" 
		// 	},
		// 	{  
		// 		id: 4,
		// 		nombre:"Articulo 4",
		// 		respuestas: [{ respuesta: "Respuesta 1"}, {respuesta: "Respuesta 2"}, {respuesta: "Respuesta 3"}], 
		// 		comentario: "Comentarios", 
		// 		contenido: "Contenido 4" 
		// 	},								
		// ];	

        // Send the form input data to process it at backend
        $scope.send_form_data = function() {

            ArticleService.create_article('POST','api/article/save',JSON.stringify($scope.form_data)).then(function(response) {

                if(response.valid == true) {

                    document.getElementById('valid-article-modal').style.display='block';
                    document.getElementById('article-modal').style.display='none';
            
                } else $scope.show_valid_modal = false;
 
            });
        }

        // Hides the valid modal when accept button is clicked 
        $scope.hide_valid_article_form = function() {
                
             document.getElementById('valid-article-modal').style.display='none';
        };		

}])