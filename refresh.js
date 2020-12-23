 
window.onbeforeunload = function() {
        return "Dude, are you sure you want to leave? Think of the kittens!";
    }
    $(document).on("submit", "form", function(event){
        window.onbeforeunload = null;
    });
 