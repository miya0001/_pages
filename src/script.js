( function() {
    if ( document.querySelector( '.underscore-pages' ) ) {
        var me = '/_pages/js/script.min.js';
        var css = '/_pages/css/style.min.css';

        var scripts = document.querySelectorAll( 'script' );
        scripts.forEach( function( item ) {
            var src = item.getAttribute( 'src' );
            if ( src ) {
                if ( 0 < src.indexOf( me ) ) {
                    css = src.replace( me, css );
                }
            }
        } );

        var link = document.createElement( 'link' );
        link.setAttribute( 'rel', 'stylesheet' );
        link.setAttribute( 'type', 'text/css' );
        link.setAttribute( 'media', 'all' );
        link.setAttribute( 'href', css );
        document.head.appendChild( link );
    }
} )();