/**
 * scripts.js
 *
 * Computer Science 50
 * Problem Set 7
 *
 * Global JavaScript, if any.
 */

$(document).ready(function() {
    /*
    $('nav-tabs li').click(function() {
        $(this).parent().children().attr
    });*/
    
   $('.task_tbl tr').click(function() {
        if( $(this).css("text-decoration") !== "none" ) {
            $(this).css("text-decoration", "none");
            $(this).children().last().children().last().children().last().css("visibility", "hidden");
        }
        else {
            $(this).css("text-decoration", "line-through");
            $(this).children().last().children().last().children().last().css("visibility", "visible");
        }
   });
   
   
   $('.completed').submit(function(event) {
       
       event.preventDefault();
       var id = $(this).children().first().val();
       var params = {
           id: id,
           completed: "true"
       };
       
       $.post("index.php", params)
       .done(function() {
           location.reload();
       })
       .fail(function() {
           alert("failed to delete task!");
       });
   });
   
 
    $('.activity_user').click(function(event) {
        event.preventDefault();
        var username = $(this).attr("href");
        var params = {
            username: username
        };
        
        $.post("profile.php", params)
        .done(function() {
            $.redirect("profile.php", {username: username});
        })
        .fail(function() {
            alert("cannot view profile");
        });
    });
    
});