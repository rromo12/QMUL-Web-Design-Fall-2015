//Helper Function (courtesy http://stackoverflow.com/questions/21607808/convert-a-youtube-video-url-to-embed-code)

function getId(url) {
    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    var match = url.match(regExp);

    if (match && match[2].length == 11) {
        return match[2];
    } else {
        return 'error';
    }
}


var app = angular.module('app')


app.controller('SanctuaryController', function($scope, $http) {
   $scope.userid=4;
   $scope.save = function(){
    console.log($scope)
    console.log("save")
    $http.post("../../../assets/php/sanctuary_save.php?userid="+$scope.userid, {
      'spotifyURI':$scope.spotifyURI, 
      'quote':$scope.quote,
      'youtubeURL':$scope.youtubeURL, 
      'imageURL':$scope.imageURL
    }).success(function(data,status,headers,config){
      console.log("success")
    });

  }
   $http.get("http://webprojects.eecs.qmul.ac.uk/rgr30/BeOne/assets/php/get_user_info.php?userid=" + $scope.userid)
   .success(function (response) {
    $scope.out = response;
  if(response[0].user_video != null)
  {
    $scope.youtubeURL = response[0].user_video;
    $scope.youtube = '<iframe width="560" height="315" src= "//www.youtube.com/embed/' + getId(response[0].user_video) + '"frameborder="0" allowfullscreen></iframe>';
    $("#video-tab").html($scope.youtube);

  }
  if(response[0].user_song !=null){
    $scope.spotifyURI = response[0].user_song;
  $scope.spotify = ' <iframe src=https://embed.spotify.com/?uri=' + response[0].user_song + '&theme=white" width="700" height="500" frameborder="0" allowtransparency="true"></iframe>'
  $("#music-tab").html($scope.spotify);

  }
  if(response[0].user_quote != null){
    $scope.quote = response[0].user_quote;
    $scope.quotes = '<center><code><h2 class="sanctuary-color" ;font-size:"4em">' +response[0].user_quote+ '</h2></code></center>'
    $("#quote-tab").html($scope.quotes);
  }
  if(response[0].user_picture!=null){
    $scope.imageURL = response[0].user_picture;
    $scope.image = '<img class="img-responsive" src =' +response[0].user_picture + '>'
    $("#picture-tab").html($scope.image);
  }

  });
});