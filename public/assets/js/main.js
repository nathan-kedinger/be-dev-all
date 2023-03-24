//variables arrow-up
let arrowTop;

let responsiveVideo, videoFacade;

window.onload = () => {

/**
 * 
 * Arrow-top
 * 
 */
 
    arrowTop = document.querySelector('.arrow-top');
 
    window.addEventListener('scroll',arrowAppear);


/**
 * 
 * lazy third part-video
 * 
 */

    responsiveVideo = document.querySelector('.video-farm');
    //responsiveVideo.style.display = "none";
    videoFacade = document.querySelector('.video-facade');
    
    videoFacade.addEventListener('mouseover',showVideo);

}




/**
 * 
 * functions
 * 
 */


/**
 * 
 * Arrow-top
 * 
 */

function arrowAppear(){
    if(window.scrollY < 100){
        arrowTop.style.opacity = "0";
        arrowTop.style.transition = "200ms linear";
    }

    if(window.scrollY > 100){
        arrowTop.style.opacity = "1";
        arrowTop.style.transition = "400ms linear";
    }
}

/**
 * 
 * lazy third part-video
 * 
 */

function showVideo(){

        responsiveVideo.style.display = "block";
        videoFacade.style.display = "none";
}
