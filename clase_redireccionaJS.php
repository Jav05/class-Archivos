<?php


Class reJs{
    
    public $pagina;
    public $host;
    public $ruta;
    public $url;
    
  public function  __construct($pagina){
      
      
        $this->pagina = $pagina;
        $this->host   = $_SERVER['HTTP_HOST'];
        $this->ruta   = '/mh5evalua/public_html';
        $html = $this->pagina;
        $this->url = "http://$this->host$this->ruta/$html";
        $url = $this->url;
        
        header("Location: $this->url");
        include ('redirect.php');
        
        die();
        
        
}
    
}