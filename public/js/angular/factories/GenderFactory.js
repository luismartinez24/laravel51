angular.module("Factory",[])

.factory("gender", function($http, Constants){
	
	return {
		 save : function(genderData) {
            return $http({
                method: 'POST',
                url: Constants.URL_API+'/api/genders',
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param(genderData)
            });
        },
        update : function(id,genderData) {
            return $http({
                method: 'PUT',
                url: Constants.URL_API+'/api/genders/'+id,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param(genderData)
            });
        }
	}

})
.factory("movie", function($http, Constants){
    return {    
        get : function() {
            return $http.get(Constants.URL_API+'/api/genders');
        },
        save : function(movieData) {
            return $http({
                method: 'POST',
                url: Constants.URL_API+'/api/movies',
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param(movieData)
            });
        }       
    }
});