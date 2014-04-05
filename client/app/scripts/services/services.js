'use strict';

angular.module('callServices', [])
	.service('caller', function ($http) {
		var url = 'http://stockandfundev.brokerstars.com:5003';

		return {
			login: function(data) {
				return $http({
					method	:	'POST',
					url		:	url + '/login',
					data	:	data
				});
			},
			logout: function(data) {
				return $http({
					method	:	'GET',
					url		:	url + '/logout',
					data	:	data
				});
			},
			ranking: function() {
				return $http({
					method	:	'GET',
					url		:	url + '/ranking'
				});
			},
			pronostico: function(data) {
				return $http({
					method	:	'POST',
					url		:	url+'/pronostico',
					data	:	data
				});
			},
			//POST /pronostico
			//pronostico: String
			//partidaId: int
			//boleto: int
			//{
			//    "data": 1
			//}

			partidaNueva: function() {
				return $http({
					method	:	'GET',
					url		:	url+'/partidaNueva'
				});
			},

		//Para coger el historial hacen falta las dos peticiones siguientes:
			//Te devuelve el id de las partidas
			historial: function() {
				return $http({
					method	:	'GET',
					url		:	url+'/historial'
				});
			},
			//Con el id de las partidas pides las partidas para coger los datos necesarios
			partidasHistorial: function(data) {
				return $http({
					method	:	'GET',
					url		:	url+'/partida/'+data
					//Con o sin :?
				});
			}
		};

	});