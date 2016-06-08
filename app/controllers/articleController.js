nbApp.controller('ArticleController', ['$scope',
	function($scope) {

		$scope.show_text = false;

		$scope.edit_article = function(article_id,text_box_id) {
			var text_box = document.getElementById(text_box_id);
			var article_content = document.getElementById(article_id).innerHTML;
			
			text_box.contentEditable="true";
			text_box.innerHTML=article_content;
			
		}

		
		$scope.articles = [
			{ 
				id: 1,
				nombre: "Articulo 1", 
				respuestas: [{ respuesta: "Respuesta 1"}, {respuesta: "Respuesta 2"}, {respuesta: "Respuesta 3"}],
				comentario: "Comentarios", 
				contenido: "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum." 
			},
			{ 
				id: 2,
				nombre:"Articulo 2",
				respuestas: [{ respuesta: "Respuesta 1"}, {respuesta: "Respuesta 2"}, {respuesta: "Respuesta 3"}], 
				comentario: "Comentarios",
				contenido: "Contenido 2" 
			},
			{ 
				id: 3,
				nombre:"Articulo 3",
				respuestas: [{ respuesta: "Respuesta 1"}, {respuesta: "Respuesta 2"}, {respuesta: "Respuesta 3"}], 
				comentario: "Comentarios", 
				contenido: "Contenido 3" 
			},
			{  
				id: 4,
				nombre:"Articulo 4",
				respuestas: [{ respuesta: "Respuesta 1"}, {respuesta: "Respuesta 2"}, {respuesta: "Respuesta 3"}], 
				comentario: "Comentarios", 
				contenido: "Contenido 4" 
			},								
		];	

}])