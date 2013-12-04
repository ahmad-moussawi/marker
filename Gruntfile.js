module.exports = function(grunt){
	grunt.initConfig({
		min:{
			options:{
				seperator: ';'
			},
			dist:{
				src: 'public/app/*.js',
				dest:'public/app.min.js'
			}
		}	
	})
}
