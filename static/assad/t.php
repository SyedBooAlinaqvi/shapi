<?php
      
    // include_once('includes/header_start.php');
     include_once('includes/session.php');
     if(!isset($_SESSION['login_user'])){     
      header("location: index.php"); // Redirecting To Home Page 
      }

      if($_GET['gender']==1 ){
            $gender="Male";   
      }
      else if ($_GET['gender']==2) {
           $gender="Female";
      }
      else{
            $gender= "Custom";
      }
      $month = date('m');
      $day = date('d');
      $year = date('Y');
      $todayDate = $day  . '-' . $month . '-' .$year;
      $name="ALI";
      require('pdf/fpdf.php');
      $pdf=new FPDF('P','mm',"A4");
      $pdf->AddPage();
      
      $pdf->SetFont('Arial','B','18');
      $pdf->Image('assets/images/pdf.jpg',10,10,190,50 ,'jpg');

      $pdf->Cell(170,20,"",0,1,'R');
      $pdf->SetFont('Arial','B','12');
      $pdf->Cell(180,20," ",0,1,'R');

      
        //patient data
     

      $pdf->SetFont('Times','B','12');
      $pdf->Cell(12,30,"MRI: ",0,0);
      $pdf->SetFont('Times','','12');
      $pdf->Cell(10,30,$_GET['MRI'] ,0,0);
      $pdf->SetFont('Times','B','12');
      $pdf->Cell(12,30,"Name: ",0,0);
      $pdf->SetFont('Times','','12');
      $pdf->Cell(30,30,$_GET['name'],0,0);
      $pdf->SetFont('Times','B','12');
      $pdf->Cell(11,30,"Visit# ",0,0);
      $pdf->SetFont('Times','','12');
      $pdf->Cell(10,30,$_GET['visits'],0,0);
      $pdf->SetFont('Times','B','12');
      $pdf->Cell(10,30,"Age: ",0,0);
      $pdf->SetFont('Times','','12');
      $pdf->Cell(15,30,$_GET['age'],0,0);
      $pdf->SetFont('Times','B','12');
      $pdf->Cell(15,30,"Gender: ",0,0);
      $pdf->SetFont('Times','','12');
      $pdf->Cell(15,30,$gender,0,0);
      $pdf->SetFont('Times','B','12');
      $pdf->Cell(13,30,"Phone: ",0,0);
      $pdf->SetFont('Times','','12');
      $pdf->Cell(20,30,$_GET['contact'],0,1);
    
      //Lines
      $pdf->Line(10, 60, 210-10, 60); 
      $pdf->Line(10, 70, 210-10, 70); 
      $pdf->Line(10, 255, 210-10, 255);
      $pdf->Line(160, 70, 210-50, 250);      
      $pdf->Line(60, 70, 210-150, 250);  
        
      //Diagnosis 
      $pdf->SetFont('Times','BIU','20');

      $pdf->Cell(70,0,"Services",0,0);
         $pdf->Cell(110,0,"History",0,1,'R');


      $pdf->SetFont('Times','B','10');
      $pdf->Cell(70,6,"",0,1);
      $pdf->Cell(70,6," 1. Permanent Hair Removal",0,1);
      $pdf->Cell(70,6,"     By Laser. ",0,1);
      $pdf->Cell(70,6,"2. Permanent Warts Removal. ",0,1); 
      $pdf->Cell(70,6,"3. HIFU Treatment For: ",0,1);
      $pdf->SetFont('Times','I','10');
      $pdf->Cell(70,6,"    a. Non Surgical Sculpting ",0,1);
      $pdf->Cell(70,6,"         of the Body.",0,1);
      $pdf->Cell(70,6,"    b. Reduction of Subcutaneous",0,1);
      $pdf->Cell(70,6,"        Fat & Improving Body.",0,1);
      $pdf->Cell(70,6,"    c. Wrinkle Reduction.   ",0,1);
      $pdf->Cell(70,6,"    d. Tightening of the Facial Skin.",0,1);
      $pdf->Cell(70,6,"    e. Tightening of the Sagging   ",0,1);
      $pdf->Cell(70,6,"        Skin.   ",0,1);
      $pdf->Cell(70,6,"    f. Lifting of the Cheeks Eyebrow ",0,1);
      $pdf->Cell(70,6,"        & Eye Lids. ",0,1);
      $pdf->Cell(70,6,"    g. Enhancing JawLine   ",0,1);
      $pdf->Cell(70,6,"        Definition.     ",0,1);
      $pdf->Cell(70,6,"    h. Improving skin Elasticity of   ",0,1);
      $pdf->Cell(70,6,"        the Cheeks, Lower Abdomen    ",0,1);
      $pdf->Cell(70,6,"        & Thighs.   ",0,1);
      $pdf->SetFont('Times','B','10');
      $pdf->Cell(70,6,"4. Microneedling For: ",0,1);
      $pdf->SetFont('Times','I','10');
      $pdf->Cell(70,6,"    a. Acne Scars & Stretch Marks.",0,1);
      $pdf->Cell(70,6,"    b. Wrinkles & Stretch Marks. ",0,1);
      $pdf->Cell(70,6,"    c. Large Pores.",0,1);
      $pdf->Cell(70,6,"    d. Age Spots ('UN spots').",0,1);
      $pdf->SetFont('Times','B','10');
      $pdf->Cell(70,6,"5. PRP For Skin Refining.  ",0,1);
      $pdf->SetFont('Times','I','10');
     // $pdf->Cell(70,6,"    a. ",0,1);
      $pdf->SetFont('Times','B','10');
      $pdf->Cell(70,6,"6. Normal Facial ",0,1);
      $pdf->Cell(70,6,"7. Customized Facial ",0,1);
      $pdf->Cell(70,6,"8. Hydra Facial ",0,1);


     

      $pdf->SetFont('Times','B','12');
      
      $pdf->Cell(20,6,"Address: ",0,0);
      $pdf->SetFont('Times','','12');
      $pdf->Cell(70,6,"Assad Aesthetics, shop# 17 - 20, First-floor Green Center, Satellite Town Market, Gujranwala",0,1);
      $pdf->SetFont('Times','','12');
      $pdf->Cell(200,6,"                                               Mob # 0333-8252542     Ph# 055-3251325 ",0,1);
      $pdf->SetFont('Times','B','12');
      $pdf->Cell(200,6,"                                                              Date: ".$todayDate,0,0);
      $pdf->output();

?>