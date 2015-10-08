<?php //CONSEJO

require('assets/lib/nusoap-0.9.5/lib/nusoap.php');
$rh = new nusoap_client('http://172.20.254.18:86/RecursosH/wsRHumanos.asmx?WSDL', true);

class webservice {

//RECURSOS HUMANOS
	public function ws_listar_empleados() {
		global $rh;
		$result = $rh->call('getListaDeEmpleadoEnPlantilla');
		$adscripciones = $result['getListaDeEmpleadoEnPlantillaResult']['Empleado'];
		if(count($result)>0){			
			foreach($adscripciones as $a => $value){
				$enlace = $value['ENLACE'];
				echo "<tr>";
				echo "<td>".$enlace."</td>";
				echo "<td>".$value['RFC']."</td>";
				echo "<td>".utf8_encode($value['NOMBRE']." ".$value['PATERNO']." ".$value['MATERNO'])."</td>";
				echo "<td>".utf8_encode($value['NOMBRE_CATEGORIA'])."</td>";
				echo "<td>".utf8_encode($value['ADSCRIPCION'])."</td>";
				echo "<td>".utf8_encode($value['ESTADO_PLAZA'])."</td>";
				echo "<td>".utf8_encode($value['COMISION'])."</td>";
				echo "<td><a href='usuario_ver_plantilla_detalle.php?e=$enlace'><i class='icon-reorder' title='Ficha Completa'></i></a></td>";
				echo "</tr>";
				}
			}
		}

	public function ws_exporta_info() {
		global $rh;
		$result = $rh->call('getListaDeEmpleadoEnPlantilla');
		$adscripciones = $result['getListaDeEmpleadoEnPlantillaResult']['Empleado'];
		if(count($result)>0){			
			foreach($adscripciones as $a => $value){
				$enlace = $value['ENLACE'];
				$rfc = $value['RFC'];												
				$nombre = $value['NOMBRE']." ".$value['PATERNO']." ".$value['MATERNO'];				
				$this->agregar_emp_v($enlace,$rfc,$nombre);
				}
			}
		}		

	public function ws_listado_plantilla_adscripcion($enl,$idadscripcion) {
		global $rh;
		$param = array("idAdscripcion" => $idadscripcion);
		$result = $rh->call('getListaEmpleadoEnPlantillaPorAdscripcionTitular',$param);
		$adscripciones = $result['getListaEmpleadoEnPlantillaPorAdscripcionTitularResult']['Empleado'];
		if(count($result)>0){			
			foreach($adscripciones as $a => $value){
				$enlace = $value['ENLACE'];
				$nom = $value['NOMBRE'];
				$pat = $value['PATERNO'];
				$mat = $value['MATERNO'];				
				$nomcom = utf8_encode($nom." ".$pat." ".$mat);
				$idads = $value['ID_ADSCRIPCION'];			
				if($enl <> $enlace){
					echo ('<option value='.utf8_encode($nom.'_'.$pat.'_'.$mat).'>'.$nomcom.'</option>');
					}				
				}
			}
		}

	public function ws_get_cfdi($enlace, $idnomina){
		global $rh;		
		$param = array("idEmpleado" => $enlace,"idNomina"=>$idnomina); 
		$result = $rh->call("GeneraPDFReciboNomina", $param); 
		return $result ["GeneraPDFReciboNominaResult"];		
		}

	public function ws_get_rfc($enlace){
		global $rh;	
		$param = array('idEmpleado' => $enlace);
		$result = $rh->call('get_empleadoPorID',$param);
		return $result['get_empleadoPorIDResult']['RFC'];
		}

	public function ws_get_nombre($enlace){
		global $rh;	
		$param = array('idEmpleado' => $enlace);
		$result = $rh->call('get_empleadoPorID',$param);
		return $result['get_empleadoPorIDResult']['NOMBRE'];
		}

	public function ws_get_apellidos($enlace){
		global $rh;	
		$param = array('idEmpleado' => $enlace);
		$result = $rh->call('get_empleadoPorID',$param);
		$ap = $result['get_empleadoPorIDResult']['PATERNO'];
		$am = $result['get_empleadoPorIDResult']['MATERNO'];
		$apellidos = $ap." ".$am;
		return $apellidos;
		}

	public function ws_get_categoria($enlace){
		global $rh;	
		$param = array('idEmpleado' => $enlace);
		$result = $rh->call('get_empleadoPorID',$param);
		return $result['get_empleadoPorIDResult']['NOMBRE_CATEGORIA'];
		}

	public function ws_get_id_adscripcion($enlace){
		global $rh;	
		$param = array('idEmpleado' => $enlace);
		$result = $rh->call('get_empleadoPorID',$param);
		return $result['get_empleadoPorIDResult']['ID_ADSCRIPCION'];
		}

	public function ws_get_id_adscripcion_titular($idadscripcion){
		global $rh;	
		$param = array('idAdscripcion' => $idadscripcion);
		$result = $rh->call('AdscripcionTitular',$param);
		return $result['AdscripcionTitularResult']['idAdscripcion'];
		}		
		
	public function ws_get_adscripcion($enlace){
		global $rh;	
		$param = array('idEmpleado' => $enlace);
		$result = $rh->call('get_empleadoPorID',$param);
		return $result['get_empleadoPorIDResult']['ADSCRIPCION'];
		}

	public function ws_get_comision($enlace){
		global $rh;	
		$param = array('idEmpleado' => $enlace);
		$result = $rh->call('get_empleadoPorID',$param);
		return $result['get_empleadoPorIDResult']['COMISION'];
		}
		
	public function ws_validar_informacion($enlace,$rfc) {
		global $rh;		
		$result = $rh->call('getListaDeEmpleadoEnPlantilla');
		$adscripciones = $result['getListaDeEmpleadoEnPlantillaResult']['Empleado'];
		if(count($result)>0){			
			foreach($adscripciones as $a => $value){
				if($enlace == $value['ENLACE']){
					echo $enlace;
					echo $value['ENLACE'];
					if($rfc == $value['RFC']){
						return 1; //INFORMACION CORRECTA
						}
					else{
						return 3; //EL ENLACE NO COINCIDE CON EL RFC
						}
					}
				else{
					return 2; //NO SE ENCONTRO EL ENLACE
					}
				}
			}
		}		
		
	}
?>