<?php
require($_SERVER['DOCUMENT_ROOT']."/application/libraries/fpdf/fpdf.php");
 
class PDF extends FPDF
{
    var $widths;
    var $aligns;

    // Cabecera de página
    function Cabecera($tit_1, $tit_2 = '', $anc_1 = 125, $anc_2 = 0)
    {        
        // Logo
        $this->Image($_SERVER['DOCUMENT_ROOT'].'/images/logo.png', 10, 3, 25);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell($anc_1,10,"$tit_1",0,0,'C');
        
        if(!empty($tit_2) && $anc_2 != 0)
        {
            // Salto de línea
            $this->Ln(10);
            // Título
            $this->Cell($anc_2,10,$tit_2,0,0,'C');
        }
        // Salto de línea
        $this->Ln(18);
        // Arial normal 
        $this->SetFont('Arial','',9);
        // Fecha
        $this->Cell(125, 10, 'Fecha de generación del reporte: '.date('Y-m-d'), 0, 0, 'L');        
        // Salto de línea
        $this->Ln(14);
    }

    //Titulo del reporte
    function Titulo($header, $w)
    {
        // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(77, 78, 148);
        $this->SetTextColor(255, 255, 255);
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(.3);  
        $this->SetFont('Arial','B',8);
        // Cabecera    
        for($i=0;$i<count($header);$i++)        
            $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        $this->Ln();
        // Restauración de colores y fuentes
        $this->SetFillColor(216,216,216);
        $this->SetTextColor(0);        
        $this->SetFont('Arial','',7);
    }

    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths=$w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }

    function Row($data)
    {
        //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=5*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            $this->Rect($x,$y,$w,$h);
            //Print the text
            $this->MultiCell($w,5,$data[$i],0,$a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w,$txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb)
        {
            $c=$s[$i];
            if($c=="\n")
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Página '.$this->PageNo().'',0,0,'C');
    }
}
?>