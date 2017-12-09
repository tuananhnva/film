<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            {{-- <video>
                <source src="http://kfilmvod.1d2173fe.viettel-cdn.vn/kfilm/mp4/20171202/751fea68-fc21-423b-983b-5382e667c7c5_3.mp4/playlist.m3u8?e=81ae650043ceed19eadbc8e5a2fabc45&expires=909081" type="">
            </video> --}}
            {{-- <video width="400" controls controlsList="download">
              <source src="http://cdn2.keeng.net/kfilm/mp4/20171202/751fea68-fc21-423b-983b-5382e667c7c5_3.mp4?e=81ae650043ceed19eadbc8e5a2fabc45&amp;expires=909081"
                           http://cdn2.keeng.net/kfilm/mp4/20171202/751fea68-fc21-423b-983b-5382e667c7c5_3.mp4/playlist.m3u8?e=81ae650043ceed19eadbc8e5a2fabc45&amp;expires=909081
                             type="video/mp4">
            </video> --}}
            <?php
                for ($i = 1; $i < 3 ; $i++)
                { 
            ?>
                <video width="400" controls controlsList="download">
                    <source src="http://wbuilding.dev/phimhayso<?php echo $i; ?>" type="video/mp4">
                </video>
            <?php
                }
            ?>
        </div>
        </div>
    </body>
</html>
