<?php

/* pChart library inclusions */
chdir("../../");
require_once("bootstrap.php");

use pChart\pColor;
use pChart\pDraw;
use pChart\pImageMap\pImageMapFile;
use pChart\pBubble;

/* Create the pChart object */
/* 							X, Y, TransparentBackground, UniqueID, StorageFolder*/
$myPicture = new pImageMapFile(700,230,FALSE,"BubbleChart","temp");

/* Retrieve the image map */
if (isset($_GET["ImageMap"])){
	$myPicture->dumpImageMap();
}

/* Populate the pData object */  
$myPicture->myData->addPoints([34,55,15,62,38,42],"Probe1");
$myPicture->myData->addPoints([5,30,20,9,15,10],"Probe1Weight");
$myPicture->myData->addPoints([5,10,-5,-1,0,-10],"Probe2");
$myPicture->myData->addPoints([6,10,14,10,14,6],"Probe2Weight");
$myPicture->myData->setSerieDescription("Probe1","This year");
$myPicture->myData->setSerieDescription("Probe2","Last year");
$myPicture->myData->setAxisName(0,"Current stock");
$myPicture->myData->addPoints(["Apple","Banana","Orange","Lemon","Peach","Strawberry"],"Product");
$myPicture->myData->setAbscissa("Product");
$myPicture->myData->setAbscissaName("Selected Products");

/* Turn off Anti-aliasing */
$myPicture->Antialias = FALSE;

/* Draw the background */
$myPicture->drawFilledRectangle(0,0,700,230,["Color"=>new pColor(170,183,87), "Dash"=>TRUE, "DashColor"=>new pColor(190,203,107)]);

/* Overlay with a gradient */
$myPicture->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,["StartColor"=>new pColor(219,231,139,50), "EndColor"=>new pColor(1,138,68,50)]);

/* Add a border to the picture */
$myPicture->drawRectangle(0,0,699,229,["Color"=>new pColor(0)]);

$myPicture->setFontProperties(["FontName"=>"pChart/fonts/Cairo-Regular.ttf","FontSize"=>7]);

/* Define the chart area */
$myPicture->setGraphArea(60,30,650,190);

/* Draw the scale */
$myPicture->drawScale(["GridColor"=>new pColor(200),"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE]);

/* Create the Bubble chart object and scale up */
$myPicture->Antialias = TRUE;
$myBubbleChart = new pBubble($myPicture);

/* Scale up for the bubble chart */
$bubbleDataSeries   = ["Probe1","Probe2"];
$bubbleWeightSeries = ["Probe1Weight","Probe2Weight"];
$myBubbleChart->bubbleScale($bubbleDataSeries,$bubbleWeightSeries);

/* Draw the bubble chart */
$myBubbleChart->drawBubbleChart($bubbleDataSeries,$bubbleWeightSeries,["RecordImageMap"=>TRUE,"ForceAlpha"=>50]);

/* Write the chart legend */
$myPicture->drawLegend(570,13,["Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL]);

/* Render the picture (choose the best way) */
$myPicture->autoOutput("temp/Bubble Chart.png");

?>