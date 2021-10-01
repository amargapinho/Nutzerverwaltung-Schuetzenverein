function zoom(out){
    const body = document.getElementsByTagName("body")[0];
    const zoomScale = 0.25;
    let zoom = parseFloat(body.style.zoom);
    if(isNaN(zoom)){
        zoom = 1;
    }
    if(out){
        if(zoom > zoomScale){
            zoom -= zoomScale;
        }
    }else {
        zoom += zoomScale;
    }
    body.style.zoom = zoom.toString();
    console.log(zoom);
}