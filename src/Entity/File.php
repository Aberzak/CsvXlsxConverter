<?php

namespace App\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class File 
{
    protected $filename;
    protected $fullFilename;
    protected $upload_directory = 'uploads';
    protected $download_directory = 'downloads';
    protected $file;
    protected $newFilename;

    public function __construct(UploadedFile $file)
    {
        $this->setFile($file);
        $this->fullFilename = $file->getClientOriginalName();
        $file->move(
            $this->upload_directory,
            $this->fullFilename 
          );

        $extention = $file->getClientOriginalExtension();
        $this->filename =  substr($this->file->getClientOriginalName(), 0 , -strlen($extention)-1);

        $this->convert();
    }

    public function getFile(): UploadedFile
    {
        return $this->file ;
    }

    public function setFile(UploadedFile $file): void
    {
        $this->file = $file;
    }

    public function getNewFilename(): string
    {
        return $this->download_directory . '/' . $this->newFilename;
    }

    private function convert()
    {        
        $extention = $this->file->getClientMimeType();
        if ($extention == 'text/csv'){
            $this->csvToXls();
        }elseif($extention == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'){
            $this->xlsxToCsv();
        }

    }

    private function csvToXls()
    {
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Csv');

        $objPHPExcel = $reader->load($this->upload_directory . '/' . $this->fullFilename);
        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
        $this->newFilename = $this->filename . '.xlsx';
        $objWriter->save($this->download_directory . '/' . $this->newFilename);
    }

    private function xlsxToCsv()
    {
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        
        $objPHPExcel = $reader->load($this->upload_directory . '/' . $this->fullFilename);
        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Csv');
        $this->newFilename = $this->filename.'.csv';
        $objWriter->save($this->download_directory . '/' . $this->newFilename);
    }
}