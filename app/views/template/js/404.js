jQuery(function ($) {
    var browserwidth  = window.innerWidth;
    var browserheight = window.innerHeight;
    var date          = new Date();
    var hours         = date.getHours();
    var month         = date.getMonth();
    var day           = date.getDate();


    //  nightmodus
    if ( hours <= 6 || hours >=18) {
        //  DISPLAY NIGHT
        $('#day').css('display','none');
        $('body').css('background-color','#3E4A5E');
        // $('.a404holder').css('background-color','rgba(0, 0, 0, 0.3)');

    } else {
        //  DISPLAY DAY
        $('#night').css('display','none');
        $('body').css('background-color','#6F9B9A');
        // $('.a404holder').css('background-color','rgba(63, 117, 115, 0.47)');
    };

    //  christmasmodus
    if ( !(month === 11) && (day > 10 && day < 27)) {
        // haal christmas weg
        $('.christmas').css('display','none');
    };


    //  animation

    //  cloud//
    TweenMax.to('.cloud1',60,
        { ease:Linear.easeNone,x: 2300})
    TweenMax.to('.cloud2',60,
        { ease:Linear.easeNone,x: 800})
    TweenMax.to('.cloud3',60,
        { ease:Linear.easeNone,x: 1200})
    TweenMax.to('.cloud4',105,
        { ease:Linear.easeNone,x: 2400,repeat:-1})
    TweenMax.to('.cloud5',75,
        {delay:4, ease:Linear.easeNone,x: 2400,repeat:-1})
    TweenMax.to('.cloud6',115,
        {delay:6, ease:Linear.easeNone,x: 2700,repeat:-1})
    TweenMax.to('.cloud7',60,
        {delay:20, ease:Linear.easeNone,x: 3000,repeat:-1})
    TweenMax.to('.cloud8',60,
        {delay:30, ease:Linear.easeNone,x: 3000,repeat:-1})
    TweenMax.to('.cloud9',70,
        {delay:30, ease:Linear.easeNone,x: 3200,repeat:-1})
    TweenMax.to('.cloud10',170,
        {delay:30, ease:Linear.easeNone,x: 4000,repeat:-1})

    //  sun & moon//
    TweenMax.to('.sunflare1', 4,
        {scale:0.7,ease: Power1.easeInOut, transformOrigin:"center",repeat:-1, yoyo:true},2);

    TweenMax.to('.sunflare2', 4,
        {scale:0.9,ease: Power1.easeInOut, transformOrigin:"center",repeat:-1, yoyo:true},2);

    TweenMax.to('.moonflare1', 4,
        {scale:0.9,ease: Power1.easeInOut, transformOrigin:"center",repeat:-1, yoyo:true},2);

    TweenMax.to('.moonflare2', 4,
        {scale:0.9,ease: Power1.easeInOut, transformOrigin:"center",repeat:-1, yoyo:true},2);

    //  sterren//
    /*TweenMax.to('.star', Math.random() * 2 + 0.5, {transformOrigin:"center",scale: Math.random() *1 + 0.5, repeat:-1, yoyo:true});
     */
    TweenMax.to('.star1', 4,
        {scale:0.5,ease: Power1.easeInOut, transformOrigin:"center",repeat:-1, yoyo:true},2);

    TweenMax.to('.star2', 4,
        {scale:0.5,ease: Power1.easeInOut, transformOrigin:"center",repeat:-1, yoyo:true},2);

    TweenMax.to('.star3', 4,
        {scale:0.5,ease: Power1.easeInOut, transformOrigin:"center",repeat:-1, yoyo:true},2);

    //  tear//
    TweenMax.to('.tear',4,
        {opacity:0,y: 20,ease: Power1.easeOut,repeat:-1, transformOrigin:"bottom"});

    //  santa
    TweenMax.to('.santa',4,
        { repeat:-1, ease:Linear.easeNone, x: -900, repeatDelay:5});

    TweenMax.from('.santa',1,
        { repeat:-1, ease:Linear.easeNone, opacity:0, repeatDelay:8});
    /*TweenMax.to('.santa',1,
     {delay:5, repeat:-1, ease:Linear.easeNone, opacity:0, repeatDelay:2});*/

    /*var tl = timelineMax();*/

});