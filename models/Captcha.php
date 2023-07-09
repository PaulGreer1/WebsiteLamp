<?php
//####################################################################
// Captcha(
//####################################################################
class Captcha
{
//####################################################################
    public $Registrar;

    public $font;
    public $signature;
    public $perturbation;             // bigger numbers give more distortion; 1 is standard
    public $imgwid;                   // image width, pixels
    public $imghgt;                   // image height, pixels
    public $numcirc;                  // number of wobbly circles
    public $numlines;                 // number of lines
    public $ncols;                    // foreground or background cols
    
//####################################################################
    // Constructor

    public function __construct( $inRegistrar )
    {
        $this->Registrar = $inRegistrar;

        $this->font = $this->Registrar->Get('Config')->FontsDir . '/DejaVuSerif-Bold.ttf';
        $this->signature = "www.topspek.com";
        $this->perturbation = 0.5;             // bigger numbers give more distortion; 1 is standard
        $this->imgwid = 200;                   // image width, pixels
        $this->imghgt = 100;                   // image height, pixels
        $this->numcirc = 4;                    // number of wobbly circles
        $this->numlines = 3;                   // number of lines
        $this->ncols = 20;                     // foreground or background cols
    }

//####################################################################
    // CCCorrect checks whether the incoming CC in $_POST matches that displayed in the image. $Captcha->IsCCCorrect( $_POST['CaptchaCode'] )

    public function IsCCCorrect( $inCC )
    {
        $CCCorrect = 0;
        $CCLookupFile = $this->Registrar->Get('Config')->CCDir . '/CCLookupFile.txt';
        $Handle = fopen( $CCLookupFile, "r" );
        flock( $Handle, LOCK_SH );
        $LineBuffer = "";
        $LineElements = array();
        $CCs = array();
        if( $Handle )
        {
            while( ! feof( $Handle ) )                                         // Loop until end of file.
            {
                $LineBuffer = fgets( $Handle, 4096 );                          // Read a line.
                $LineBuffer = str_replace( "\n", "", $LineBuffer );
                $LineBuffer = str_replace( "\r", "", $LineBuffer );
                $LineElements = preg_split( "/ /", $LineBuffer );
                $key = $LineElements[0];
                //$CCs[$key] = $LineElements[1];
                $CCs[$key] = null;
            }
            fclose( $Handle );
        }

        if( isset( $inCC ) && empty( $inCC ) )
        {
            $inCC = "asdf";
        }

        if( array_key_exists( $inCC, $CCs ) )
        {
            $CCCorrect = 1;
            //unlink( "{$CCs[$_POST['CaptchaCode']]}.png" );
        }

        return $CCCorrect;
    }

//####################################################################
    // StoreCCImgFilePair generates a unique captcha code (CC) and a unique name for the .png image file, and writes the CC and .png image file association to a lookup file.

    public function StoreCCImgFilePair( $inCC, $inCCPngName )
    {
        $CCLookupFile = $this->Registrar->Get('Config')->CCDir . '/CCLookupFile.txt';
        $Handle = fopen( $CCLookupFile, "a" );
        flock( $Handle, LOCK_EX );
        if( $Handle )
        {
            fwrite( $Handle, "{$inCC} {$inCCPngName}\n" );
        }
        fclose( $Handle );
    }

//####################################################################
    // CreateCC generates a captcha code consisting of 5 upper case letters.

    public function CreateCC()
    {
        $Letters = "ABDEFHKLMNOPRSTUVWXZ";
        $CC = "";
        for( $i = 0; $i < 5; ++$i )                                              // create the captcha code
        {
            $CC .= substr( $Letters, rand( 0, strlen( $Letters ) - 1 ), 1 );
        }
        return $CC;
    }

//####################################################################
    // CreateCCPngName generates a bare file name (no path, no extension) consisting of 5 upper case letters.

    public function CreateCCPngName()
    {
        $Letters = "ABDEFHKLMNOPRSTUVWXZ";
        $CCPngName = "";                            // this will be the bare file name without the path or extension - e.g. 'XHDJR'...
        for( $i = 0; $i < 5; ++$i )                 // create the bare file name...
        {
            $CCPngName .= substr( $Letters, rand( 0, strlen( $Letters ) - 1 ), 1 );
        }
        return $CCPngName;
    }

//####################################################################
public function frand()
{
  return 0.0001*rand(0,9999);
}

//####################################################################
    // randomline

    public function randomline($img, $col, $x, $y)
    {
        $theta = ($this->frand()-0.5)*M_PI*0.7;
//        global $this->imgwid;
        $len = rand($this->imgwid*0.4,$this->imgwid*0.7);
        $lwid = rand(0,2);

        $k = $this->frand()*0.6+0.2; $k = $k*$k*0.5;
        $phi = $this->frand()*6.28;
        $step = 0.5;
        $dx = $step*cos($theta);
        $dy = $step*sin($theta);
        $n = $len/$step;
        $amp = 1.5*$this->frand()/($k+5.0/$len);
        $x0 = $x - 0.5*$len*cos($theta);
        $y0 = $y - 0.5*$len*sin($theta);

        $ldx = round(-$dy*$lwid);
        $ldy = round($dx*$lwid);
        for ($i = 0; $i < $n; ++$i)
        {
            $x = intval( $x0+$i*$dx + $amp*$dy*sin($k*$i*$step+$phi) );
            $y = intval( $y0+$i*$dy - $amp*$dx*sin($k*$i*$step+$phi) );
            imagefilledrectangle($img, $x, $y, $x+$lwid, $y+$lwid, $col);
        }
    }

//####################################################################
    // amp = amplitude (<1), num=numwobb (<1)

    public function imagewobblecircle($img, $xc, $yc, $r, $wid, $amp, $num, $col)
    {
        $dphi = 1;
        if ($r > 0)
        {
            $dphi = 1/(6.28*$r);
        }
        $woffs = rand(0,100)*0.06283;
        for ($phi = 0; $phi < 6.3; $phi += $dphi)
        {
            $r1 = $r * (1-$amp*(0.5+0.5*sin($phi*$num+$woffs)));
            $x = intval( $xc + $r1*cos($phi) );
            $y = intval( $yc + $r1*sin($phi) );
            imagefilledrectangle($img, $x, $y, $x+$wid, $y+$wid, $col);
        }
    }

//####################################################################
    // make a distorted copy from $tmpimg to $img. $wid, $height apply to $img,
    // $tmpimg is a factor $iscale bigger.

    public function distorted_copy($tmpimg, $img, $width, $height, $iscale)
    {
        $numpoles = 3;

        // make an array of poles AKA attractor points
//        global $this->perturbation;
        for ($i = 0; $i < $numpoles; ++$i)
        {
            do
            {
                $px[$i] = rand(0, $width);
            }
            while ($px[$i] >= $width*0.3 && $px[$i] <= $width*0.7);
            do
            {
                $py[$i] = rand(0, $height);
            }
            while ($py[$i] >= $height*0.3 && $py[$i] <= $height*0.7);
            $rad[$i] = rand($width*0.4, $width*0.8);
            $tmp = -$this->frand()*0.15-0.15;
            $amp[$i] = $this->perturbation * $tmp;
        }

        // get img properties bgcolor
        $bgcol = imagecolorat($tmpimg, 1, 1);
        $width2 = $iscale*$width;
        $height2 = $iscale*$height;
  
        // loop over $img pixels, take pixels from $tmpimg with distortion field
        for ($ix = 0; $ix < $width; ++$ix)
        {
            for ($iy = 0; $iy < $height; ++$iy)
            {
                $x = $ix;
                $y = $iy;
                for ($i = 0; $i < $numpoles; ++$i)
                {
                    $dx = $ix - $px[$i];
                    $dy = $iy - $py[$i];
                    if ($dx == 0 && $dy == 0)
                        continue;
                    $r = sqrt($dx*$dx + $dy*$dy);
                    if ($r > $rad[$i])
                        continue;
                    $rscale = $amp[$i] * sin(3.14*$r/$rad[$i]);
                    $x += $dx*$rscale;
                    $y += $dy*$rscale;
                }
                $c = $bgcol;
                $x *= $iscale;
                $y *= $iscale;
                if ($x >= 0 && $x < $width2 && $y >= 0 && $y < $height2)
                    $c = imagecolorat( $tmpimg, intval( $x ), intval( $y ) );
                imagesetpixel($img, $ix, $iy, $c);
            }
        }
    }

//####################################################################
    // add grid for debugging purposes

    public function addgrid($tmpimg, $width2, $height2, $iscale, $color)
    {
        $lwid = floor($iscale*3/2);
        imagesetthickness($tmpimg, $lwid);
        for ($x = 4; $x < $width2-$lwid; $x+=$lwid*2)
            imageline($tmpimg, $x, 0, $x, $height2-1, $color);
        for ($y = 4; $y < $height2-$lwid; $y+=$lwid*2)
            imageline($tmpimg, 0, $y, $width2-1, $y, $color);
    }

//####################################################################
    // warped_text_image

    public function warped_text_image($width, $height, $string)
    {
        // internal variablesinternal scale factor for antialias
        $iscale = 3;

        // initialize temporary image
        $width2 = $iscale*$width;
        $height2 = $iscale*$height;
        $tmpimg = imagecreate($width2, $height2);
        $bgColor = imagecolorallocatealpha ($tmpimg, 192, 192, 192, 100);
        $col = imagecolorallocate($tmpimg, 0, 0, 0);

        // init final image
        $img = imagecreate($width, $height);
        imagepalettecopy($img, $tmpimg);    
        imagecopy($img, $tmpimg, 0,0 ,0,0, $width, $height);
  
        // put straight text into $tmpimage
//        global $this->font;
        $fsize = $height2*0.25;
        $bb = imageftbbox($fsize, 0, $this->font, $string);
        $tx = $bb[4]-$bb[0];
        $ty = $bb[5]-$bb[1];
        $x = floor($width2/2 - $tx/2 - $bb[0]);
        $y = round($height2/2 - $ty/2 - $bb[1]);
        imagettftext($tmpimg, $fsize, 0, $x, $y, -$col, $this->font, $string);

        // $this->addgrid($tmpimg, $width2, $height2, $iscale, $col); // debug

        // warp text from $tmpimg into $img
        $this->distorted_copy($tmpimg, $img, $width, $height, $iscale);

        // add wobbly circles (spaced)
//        global $this->numcirc;
        for ($i = 0; $i < $this->numcirc; ++$i)
        {
            $x = $width * (1+$i) / ($this->numcirc+1);
            $x += (0.5-$this->frand())*$width/$this->numcirc;
            $y = rand($height*0.1, $height*0.9);
            $r = $this->frand();
            $r = ($r*$r+0.2)*$height*0.2;
            $lwid = rand(0,2);
            $wobnum = rand(1,4);
            $wobamp = $this->frand()*$height*0.01/($wobnum+1);
            $this->imagewobblecircle($img, $x, $y, $r, $lwid, $wobamp, $wobnum, $col);
        }
  
        // add wiggly lines
//        global $this->numlines;
        for ($i = 0; $i < $this->numlines; ++$i)
        {
            $x = $width * (1+$i) / ($this->numlines+1);
            $x += (0.5-$this->frand())*$width/$this->numlines;
            $y = rand($height*0.1, $height*0.9);
            $this->randomline($img, $col, $x, $y);
        }

        return $img;
    }

//####################################################################
    // add_text

    public function add_text($img, $string)
    {
        $cmtcol = imagecolorallocatealpha ($img, 128, 0, 0, 64);
        imagestring($img, 5, 10, imagesy($img)-20, $string, $cmtcol);
    }

}
//####################################################################

    // CreateCCPngImgFilename

//    public function CreateCCPngImageFilename( $inCCPngName )
//    {
//echo 'HERE';
//        $CCPngImgFilename = "";                             // the png image file...
//        $PngFileExists = 1;                             // assume the png image file already exists...
//        while( $PngFileExists )
//        {
//            $CCPngImgFilename = $this->Registrar->Get('Config')->CCDir . '/' . $inCCPngName . '.png';
//            if( ! file_exists( $CCPngImgFilename ) )                                               // check that the bare file name we just created doesn't already
//            {                                                                                      // exist...if not, the current while loop will terminate...
//                $PngFileExists = 0;
//            }
//        }
//        return $CCPngImgFilename;
//    }

//####################################################################
?>
