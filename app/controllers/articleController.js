nbApp.controller('ArticleController', ['$scope',
	function($scope) {

		$scope.mostrar_text_area = false;

		$scope.articles = [
			{ 
				nombre: "Articulo 1", 
				respuestas: [{ respuesta: "Respuesta 1"}, {respuesta: "Respuesta 2"}, {respuesta: "Respuesta 3"}],
				comentario: "Comentarios", 
				contenido: "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum." 
			},
			{ 
				nombre:"Articulo 2",
				respuestas: [{ respuesta: "Respuesta 1"}, {respuesta: "Respuesta 2"}, {respuesta: "Respuesta 3"}], 
				comentario: "Comentarios",
				contenido: "Contenido 2" 
			},
			{ 
				nombre:"Articulo 3",
				respuestas: [{ respuesta: "Respuesta 1"}, {respuesta: "Respuesta 2"}, {respuesta: "Respuesta 3"}], 
				comentario: "Comentarios", 
				contenido: "Contenido 3" 
			},
			{ 
				nombre:"Articulo 4",
				respuestas: [{ respuesta: "Respuesta 1"}, {respuesta: "Respuesta 2"}, {respuesta: "Respuesta 3"}], 
				comentario: "Comentarios", 
				contenido: "Contenido 4" 
			},								
		];	

}])