function O(i) { 
    return typeof i == 'object' ? i : document.getElementById(i);
}

function S(i) { 
    return O(i).style
}

function C(i) { 
    return document.getElementsByClassName(i)
}


window.onload=function(){
    var x = document.getElementById("messagesContainer");
    
    

    x.addEventListener("scroll", function(){
        
        var scrollTop = x.scrollTop;
        var offsetHeight = x.offsetHeight;
        var clientHt = x.clientHeight;
    
        var scrollHt = x.scrollHeight;
        var scrollTp = x.scrollTop;
        /*if (offsetHeight <= scrollTop + clientHeight) */ 
        
        /*console.log("HT" + scrollHt);
        console.log("Tp" + scrollTp);
        console.log("client" + clientHt);*/
        console.log("dif" + (scrollHt - scrollTp));
        
        
        if (scrollHt - scrollTp === clientHt){
            // add more message divs
            // query content from DB and add into divs
        
            x.style.backgroundColor = "red";
            
            $('#messagesContainer').append("<div class='messageContent'>1</div>\
                        <div class='messageContent'>2</div>\
                        <div class='messageContent'>3</div>\
                        <div class='messageContent'>4</div>\
                        ");
            
            
        }
        
                       });
}


//function scrollHandler() {
//        
////the Element.scrollTop property gets or sets the number of pixels that an element's content is scrolled vertically.
////An element's scrollTop value is a measurement of the distance from the element's top to its topmost visible content. //  When an element's content does not generate a vertical scrollbar, then its scrollTop value is 0.
//        
//
//        /*if (offsetHeight <= scrollTop + clientHeight){*/
//    
//    
//    
//    
//        /*if (scrollHeight - x.scrollTop === x.clientHeight) {*/
//    if (scrollHt - scrollTp === clientHt){
//            x.style.backgroundColor = "red";
//        }
//}

//The following equivalence returns true if an element is at the end of its scroll, false if it isn't.

//element.scrollHeight - element.scrollTop === element.clientHeight




 //The HTMLElement.offsetHeight read-only property returns the height of an element, including vertical padding and 
//borders, as an integer.
    
    
//The Element.scrollHeight read-only property is a measurement of the height of an element's content, including content 
    //not visible on the screen due to overflow.