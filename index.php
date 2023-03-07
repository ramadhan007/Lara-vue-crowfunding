
<?php


trait Hewan{
    public $namaHewan;
    public $aksi;
    public $attackPower;
    public $defencePower;

    public function atraksi(){
        echo "{$this->nama} sedang {$this->aksi}";
    }

}

trait Fightt{
    use Hewan;
    public $nama;
    public $aksi;
    public $attackPower;
    public $defencePower;

public function serang($hewan){
    echo "{this->nama} serang {$hewan->namaHewan}";
}
}

class Fight
{
    private $jenis;
    private $serang;
    private $diserang;
 
  public function setJenis($jenis)
 {
    $this->jenis=$jenis;
  }
    public function getJenis()
  {
    return $this->jenis;
  }

  public function setSerang($serang)
  {
     $this->serang=$serang;
   }
     public function getSerang()
   {
     return $this->serang;
   }
   public function setDiserang($diserang)
   {
      $this->diserang=$diserang;
    }
      public function getDiserang()
    {
      return $this->diserang;
    }

   


}

class Kambing extends Fight
{
    public $kaki;
    public $atttackPower;
    public $differencePower;
}
class Harimau extends Fight
{
    public $kaki;
    public $atttackPower;
    public $differencePower;

}
class Singa extends Fight
{
    public $kaki;
    public $atttackPower;
    public $differencePower;
}

$kambing = new Kambing();
$kambing->setJenis('Herbivora');
$harimau = new Harimau();
$harimau->setJenis('Karnivora');
$singa = new singa();
$singa->setJenis('Karnivora');
echo $kambing->getJenis();
echo PHP_EOL;
echo $harimau->getJenis();
echo PHP_EOL;
echo $singa->getJenis();?>