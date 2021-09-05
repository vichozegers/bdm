<?php

require_once("clases/Salud/CAdminCirujias.php");
require_once("clases/Salud/CAdminFracturas.php");
require_once("clases/Salud/CAdminEnfermedades.php");
require_once("clases/Salud/CAdminAlergias.php");
require_once("clases/Salud/CAdminAutomedica.php");
require_once("clases/Salud/CAdminControlEspecialidades.php");
require_once("clases/Salud/CAdminHospitalizaciones.php");
require_once("clases/Salud/CAdminHospitalizacionesPsiquiatricas.php");
require_once("clases/Salud/CAdminMedicamentos.php");
require_once("clases/Social/Postulaciones/CAdminProcesoPostulacion.php");
require_once("clases/Social/Postulaciones/CAdminSolicitudes.php");
require_once("clases/Salud/CEvaluacionMedica.php");
require_once("clases/Salud/CAdminTratAgitaciones.php");
require_once("clases/Salud/CAdminHabitosSuenio.php");
require_once("clases/Salud/CAdminMinimental.php");    // Agregado para minimental
require_once("clases/Salud/CAdminBarthel.php");       // Agregado para barthel
require_once("clases/Residentes/CAdminEventos.php");  // Agregado para Envio de Email por nueva Enfermedad

class CAdminEvaluacionMedica {

    public static function IngresarEvMedica(&$evaluacio, $id_soli) {
        $pp = CAdminProcesoPostulacion::GetProcesoPostulacionIdSolicitud($id_soli);
        $query = "INSERT INTO evaluacion_medica (proceso_postulacion_idproceso_postulacion,
        fecha_realizacion, consultorio, ultimo_control, no_farmacologico, habito_alcohol, tiempo_detencion,
        deprimido, nervioso, agitacion, agitacion2, alteracion_memoria, numero_caidas, fecha_ultima_caida,
        consecuencias, peso, talla, clasif_nutricional, alimentacion, conciencia_vigil, conciencia_orientada, vision,
        audicion, hidratacion, corazon, pulmones, abdomen, extremidades_sup, extremidades_inf, marcha, medica,
        salud_mental, comentarios, recomendacion, lavado, vestido, wc, movilidad, continencia, alimentacion2, quien_responde,
        donde_se_encuentra_iddonde_se_encuentra, piel, funcional, desc_agitacion, escaras, minimental, deterioro, 
        puntaje_barthel, grado_dependencia, 
        t_nuevaenfermedad, obs_nuevaenfermedad,
        t_cirujias, t_alimentaria, t_farma, t_otra, t_frac, t_hosp, t_cpe, t_medicamentos, t_automedica, t_trat_agi, t_hos_psiqui, alimentacion_otro) VALUES(" .
                $pp->GetId() . ", '" . $evaluacio->GetFechaEvaluacion() . "', '" . $evaluacio->GetConsultorio() .
                "', '" . $evaluacio->GetUltimoControl() . "', '" . $evaluacio->GetTratamientoNoFarmacologico() . "', '" . $evaluacio->GetHabitoDeAlcohol() .
                "', '" . $evaluacio->GetAlcoholDetenido() . "', " . $evaluacio->GetDepresion() . ", " . $evaluacio->GetNervioso() . ", " .
                $evaluacio->GetAgitacionPsicomotora() . ", '" . $evaluacio->GetTiempoAgitacion() . "', '" . $evaluacio->GetAlteracionesMemoria() . "','" .
                $evaluacio->GetCaidasUltimoAnio() . "', '" . $evaluacio->GetFechaUltimaCaida() . "', '" . $evaluacio->GetConsecuencia() . "', '" . $evaluacio->GetPeso() . "', '" .
                $evaluacio->GetTalla() . "', '" . $evaluacio->GetClasificacionNutricional() . "', '" . $evaluacio->GetAlimentacion() . "', " . $evaluacio->GetConcienciaVigil() . ", " .
                $evaluacio->GetConcienciaOrientada() . ",'" . $evaluacio->GetVision() . "', '" . $evaluacio->GetAudicion() . "', '" . $evaluacio->GetHidratacion() . "', '" . $evaluacio->GetCorazon() . "', '" .
                $evaluacio->GetPulmones() . "', '" . $evaluacio->GetAbdomen() . "', '" . $evaluacio->GetExtremedadesSuperiores() . "', '" . $evaluacio->GetExtremidadesInferiores() . "', '" .
                $evaluacio->GetMarcha() . "', '" . $evaluacio->GetMedica() . "', '" . $evaluacio->GetSaludMental() . "', '" . $evaluacio->GetComentarios() . "', '" . $evaluacio->GetRecomendacion() . "', " .
                $evaluacio->GetKatzLavado() . ", " . $evaluacio->GetKatzVestido() . ", " . $evaluacio->GetKatzWc() . ", " . $evaluacio->GetKatzMovilidad() . ", " .
                $evaluacio->GetKatzContinencia() . ", " . $evaluacio->GetKatzAlimentacion() . ", " . $evaluacio->GetQuienReponde() . ", " . CAdminSolicitudes::GetDondeSeEncuentraId($evaluacio->GetLugarResidencia()) . ", '" .
                $evaluacio->GetPiel() . "', '" . $evaluacio->GetFuncional() . "', '" . $evaluacio->GetDescripcionAgitacion() . "', '" . $evaluacio->GetEscaras() . "'," . $evaluacio->GetMinimental() . ",'" . $evaluacio->GetDeterioro() . "'," .
                $evaluacio->GetPuntajeBarthel() . ",'" . $evaluacio->GetGradoDependencia() . "'," .
                $evaluacio->GetTieneNuevaEnfermedad() . ", '" . $evaluacio->GetObsNuevaEnfermedad() . "', " .
                $evaluacio->GetTieneCirugias() . "," . $evaluacio->GetTieneAlAlimentaria() . "," . $evaluacio->GetTieneAlFarmacologica() . "," . $evaluacio->GetTieneAlOtra() . "," . $evaluacio->GetTieneFracturas() . "," .
                $evaluacio->GetTieneHospitalizaciones() . "," . $evaluacio->GetTieneCPE() . "," . $evaluacio->GetTieneMedicamentos() . "," . $evaluacio->GetTieneAutomedica() . "," . $evaluacio->GetTieneTratAgi() . "," . $evaluacio->GetTieneHospPsiquiatricas() . ",'" . $evaluacio->GetAlimentacionOtra() . "')";
        $con = CDBSingleton::GetConn();
        $exito = $con->query(str_replace("\n", "", $query));
        if (CDBSingleton::RevisarExito($exito, $query)) {
            $id_evm = CDBSingleton::GetUltimoId();

            CAdminPersonas::ActualizarAdultoMayorEvMedica($pp->GetIdAdultoMayor(), 1);

            // ********************  MINIMENTAL *************************
            CAdminMinimental::IngresarMinimental($evaluacio, $id_evm);
            // ***********************************************************
            // *********************  BARTHEL ***************************
            CAdminBarthel::IngresarBarthel($evaluacio, $id_evm);
            // ***********************************************************
            //cirujias
            for ($i = 0, $cir = $evaluacio->GetCirujias(); $i < count($evaluacio->GetCirujias()); $i++) {
                CAdminCirujias::IngresarCirujia($cir[$i], $id_evm);
            }
            //enfermedades
            for ($i = 0, $enf = $evaluacio->GetEnfermedades(); $i < count($evaluacio->GetEnfermedades()); $i++) {
                CAdminEnfermedades::IngresarEnfermedadesEvMedica($enf[$i], $id_evm);
            }
            //fracturas
            for ($i = 0, $fra = $evaluacio->GetFracturas(); $i < count($evaluacio->GetFracturas()); $i++) {
                CAdminFracturas::IngresarFractura($fra[$i], $id_evm);
            }
            //alergias
            for ($i = 0, $farma = $evaluacio->GetFarmacologica(); $i < count($evaluacio->GetFarmacologica()); $i++) {
                CAdminAlergias::IngresarAlergia($farma[$i], $id_evm);
            }
            for ($i = 0, $alim = $evaluacio->GetAlimentaria(); $i < count($evaluacio->GetAlimentaria()); $i++) {
                CAdminAlergias::IngresarAlergia($alim[$i], $id_evm);
            }
            for ($i = 0, $otra = $evaluacio->GetOtras(); $i < count($evaluacio->GetOtras()); $i++) {
                CAdminAlergias::IngresarAlergia($otra[$i], $id_evm);
            }
            //hospitalizaciones
            for ($i = 0, $hosp = $evaluacio->GetHospitalizaciones(); $i < count($evaluacio->GetHospitalizaciones()); $i++) {
                CAdminHospitalizaciones::IngresarHospitalizacion($hosp[$i], $id_evm);
            }
            //control especialidades
            for ($i = 0, $cep = $evaluacio->GetControlEspecialidades(); $i < count($evaluacio->GetControlEspecialidades()); $i++) {
                CAdminControlEspecialidades::IngresarControlEspecialidades($cep[$i], $id_evm);
            }
            //medicamentos
            for ($i = 0, $med = $evaluacio->GetMedicamentos(); $i < count($evaluacio->GetMedicamentos()); $i++) {
                CAdminMedicamentos::IngresarMedicamentos($med[$i], $id_evm);
            }
            // asdasdasd
            for ($i = 0, $hsu = $evaluacio->GetHabitoSuenio(); $i < count($evaluacio->GetHabitoSuenio()); $i++) {
                CAdminHabitosSuenio::IngresarHSuenioEvMedica($hsu[$i], $id_evm);
            }
            // asdasdasd
            for ($i = 0, $trat = $evaluacio->GetTratamientos(); $i < count($evaluacio->GetTratamientos()); $i++) {
                CAdminTratamientoAgitacion::IngresarTratAgitaciones($trat[$i], $id_evm);
            }
            //automedica
            for ($i = 0, $auto = $evaluacio->GetAutomedica(); $i < count($evaluacio->GetAutomedica()); $i++) {
                CAdminAutomedica::IngresarAutomedica($auto[$i], $id_evm);
            }
            //hospitalizaciones psiquiatricas
            for ($i = 0, $hpsi = $evaluacio->GetHospitalizacionesSiquiatricas(); $i < count($evaluacio->GetHospitalizacionesSiquiatricas()); $i++) {
                CAdminHospitalizacionesPsiquiatricas::IngresarHospitalizacionPsi($hpsi[$i], $id_evm);
            }
            $log = new CLog();
            $log->SetFecha(date("Y-m-d H:i:s"));
            $log->SetEvento("Ingreso de Ev. Medica");
            $log->SetAdultoMayor($pp->GetIdAdultoMayor());
            $log->SetObservaciones("Evaluacion Medica id=" . $id_evm);
            $log->SetUsuario(CAdminSesion::NombreUsuario());
            CAdminLog::Insertar($log);

            if ($evaluacio->GetObsNuevaEnfermedad() <> '') {
                CAdminEventos::SendMailAvisoNuevaEnfermedad($pp->GetIdAdultoMayor(), $evaluacio->GetObsNuevaEnfermedad());
            }

            return $id_evm;
        }
    }

    public static function GetEvMedica($id_evm) {
        $query = "select * from evaluacion_medica where idevaluacion_medica=" . $id_evm;
        $con = CDBSingleton::GetConn();
        $exito = $con->query($query);
        if (CDBSingleton::RevisarExito($exito, $query)) {
            if ($exito->numrows() > 0) {
                $rs = $exito->fetchrow(DB_FETCHMODE_ASSOC);
                return self::CrearEvMedica($rs);
            }
        }
    }

    public static function CrearEvMedica($rs) {
        $evm = new CEvaluacionMedica();
        $evm->SetEnfermedades(CAdminEnfermedades::GetEnfermedadesEvMedica($rs['idevaluacion_medica']));
        $evm->SetCirujias(CAdminCirujias::GetCirujias($rs['idevaluacion_medica']));
        $evm->SetFracturas(CAdminFracturas::GetFracturas($rs['idevaluacion_medica']));
        $evm->SetFarmacologica(CAdminAlergias::GetAlergias($rs['idevaluacion_medica'], 'farmacologica'));
        $evm->SetAlimentaria(CAdminAlergias::GetAlergias($rs['idevaluacion_medica'], 'alimentaria'));
        $evm->SetOtras(CAdminAlergias::GetAlergias($rs['idevaluacion_medica'], 'otras'));
        $evm->SetHospitalizaciones(CAdminHospitalizaciones::GetHospitalizaciones($rs['idevaluacion_medica']));
        $evm->SetControlEspecialidades(CAdminControlEspecialidades::GetControlEspecialidades($rs['idevaluacion_medica']));
        $evm->SetMedicamentos(CAdminMedicamentos::GetMedicamentos($rs['idevaluacion_medica']));
        $evm->SetAutomedica(CAdminAutomedica::GetAutomedica($rs['idevaluacion_medica']));
        $evm->SetHospitalizacionesSiquiatricas(CAdminHospitalizacionesPsiquiatricas::GetHospitalizacionesPsi($rs['idevaluacion_medica']));
        $evm->SetTratamientos(CAdminTratamientoAgitacion::GetTratAgitaciones($rs['idevaluacion_medica']));
        $evm->SetHabitoSuenio(CAdminHabitosSuenio::GetHSuenioEvMedica($rs['idevaluacion_medica']));
        $evm->SetId($rs['idevaluacion_medica']);
        $evm->SetProcesoPostulacion($rs['proceso_postulacion_idproceso_postulacion']);
        $evm->SetFechaEvaluacion($rs['fecha_realizacion']);
        $evm->SetConsultorio($rs['consultorio']);
        $evm->SetUltimoControl($rs['ultimo_control']);
        $evm->SetTratamientoNoFarmacologico($rs['no_farmacologico']);
        $evm->SetHabitoDeAlcohol($rs['habito_alcohol']);
        $evm->SetAlcoholDetenido($rs['tiempo_detencion']);
        $evm->SetDepresion($rs['deprimido']);
        $evm->SetNervioso($rs['nervioso']);
        $evm->SetAgitacionPsicomotora($rs['agitacion']);
        $evm->SetTiempoAgitacion($rs['agitacion2']);
        $evm->SetAlteracionesMemoria($rs['alteracion_memoria']);
        $evm->SetCaidasUltimoAnio($rs['numero_caidas']);
        $evm->SetFechaUltimaCaida($rs['fecha_ultima_caida']);
        $evm->SetConsecuencia($rs['consecuencias']);
        $evm->SetPeso($rs['peso']);
        $evm->SetTalla($rs['talla']);
        $evm->SetClasificacionNutricional($rs['clasif_nutricional']);
        $evm->SetAlimentacion($rs['alimentacion']);
        $evm->SetConcienciaVigil($rs['conciencia_vigil']);
        $evm->SetConcienciaOrientada($rs['conciencia_orientada']);
        $evm->SetHidratacion($rs['hidratacion']);
        $evm->SetCorazon($rs['corazon']);
        $evm->SetPulmones($rs['pulmones']);
        $evm->SetAbdomen($rs['abdomen']);
        $evm->SetExtremedadesSuperiores($rs['extremidades_sup']);
        $evm->SetExtremidadesInferiores($rs['extremidades_inf']);
        $evm->SetMarcha($rs['marcha']);
        $evm->SetMedica($rs['medica']);
        $evm->SetSaludMental($rs['salud_mental']);
        $evm->SetComentarios($rs['comentarios']);
        $evm->SetRecomendacion($rs['recomendacion']);
        $evm->SetKatzLavado($rs['lavado']);
        $evm->SetKatzVestido($rs['vestido']);
        $evm->SetKatzWc($rs['wc']);
        $evm->SetKatzMovilidad($rs['movilidad']);
        $evm->SetKatzContinencia($rs['continencia']);
        $evm->SetKatzAlimentacion($rs['alimentacion2']);
        $evm->SetQuienReponde($rs['quien_responde']);
        $evm->SetLugarResidencia(CAdminSolicitudes::GetDondeSeEncuentraNombre($rs['donde_se_encuentra_iddonde_se_encuentra']));
        $evm->SetPiel($rs['piel']);
        $evm->SetFuncional($rs['funcional']);
        $evm->SetDescripcionAgitacion($rs['desc_agitacion']);
        $evm->SetVision($rs['vision']);
        $evm->SetAudicion($rs['audicion']);
        $evm->SetEscaras($rs['escaras']);
        $evm->SetTieneAlAlimentaria($rs['t_alimentaria']);
        $evm->SetTieneAlFarmacologica($rs['t_farma']);
        $evm->SetTieneAlOtra($rs['t_otra']);
        $evm->SetTieneAutomedica($rs['t_automedica']);
        $evm->SetTieneCPE($rs['t_cpe']);
        $evm->SetTieneCirugias($rs['t_cirujias']);
        $evm->SetTieneFracturas($rs['t_frac']);
        $evm->SetTieneHospPsiquiatricas($rs['t_hos_psiqui']);
        $evm->SetTieneHospitalizaciones($rs['t_hosp']);
        $evm->SetTieneMedicamentos($rs['t_medicamentos']);
        $evm->SetTieneTratAgi($rs['t_trat_agi']);
        $evm->SetAlimentacionOtra($rs['alimentacion_otro']);

        $evm->SetTieneNuevaEnfermedad($rs['t_nuevaenfermedad']);
        $evm->SetObsNuevaEnfermedad($rs['obs_nuevaenfermedad']);

        // **************************************************************
        // ******************* INICIO MINIMENTAL ************************
        // **************************************************************

        $evm->SetMinimental($rs['minimental']);

        if ($rs['minimental'] != 0 && $rs['minimental'] != NULL) {

            //******************* MINIMENTAL
            $evm->SetDeterioro($rs['deterioro']);

            $evm->SetUnoMes(CAdminMinimental::GetMinimental($rs['idevaluacion_medica'], 'uno_mes'));
            $evm->SetUnoDia(CAdminMinimental::GetMinimental($rs['idevaluacion_medica'], 'uno_dia_mes'));
            $evm->SetUnoAnno(CAdminMinimental::GetMinimental($rs['idevaluacion_medica'], 'uno_anno'));
            $evm->SetUnoDiaSemana(CAdminMinimental::GetMinimental($rs['idevaluacion_medica'], 'uno_dia_semana'));
            $evm->SetDosObjeto1(CAdminMinimental::GetMinimental($rs['idevaluacion_medica'], 'dos_objeto1'));
            $evm->SetDosObjeto2(CAdminMinimental::GetMinimental($rs['idevaluacion_medica'], 'dos_objeto2'));
            $evm->SetDosObjeto3(CAdminMinimental::GetMinimental($rs['idevaluacion_medica'], 'dos_objeto3'));
            $evm->SetDosRepeticiones(CAdminMinimental::GetMinimental($rs['idevaluacion_medica'], 'dos_repeticiones'));
            $evm->SetTresN1(CAdminMinimental::GetMinimental($rs['idevaluacion_medica'], 'tres_n1'));
            $evm->SetTresN2(CAdminMinimental::GetMinimental($rs['idevaluacion_medica'], 'tres_n2'));
            $evm->SetTresN3(CAdminMinimental::GetMinimental($rs['idevaluacion_medica'], 'tres_n3'));
            $evm->SetTresN4(CAdminMinimental::GetMinimental($rs['idevaluacion_medica'], 'tres_n4'));
            $evm->SetTresN5(CAdminMinimental::GetMinimental($rs['idevaluacion_medica'], 'tres_n5'));
            $evm->SetCuatroAccion1(CAdminMinimental::GetMinimental($rs['idevaluacion_medica'], 'cuatro_accion1'));
            $evm->SetCuatroAccion2(CAdminMinimental::GetMinimental($rs['idevaluacion_medica'], 'cuatro_accion2'));
            $evm->SetCuatroAccion3(CAdminMinimental::GetMinimental($rs['idevaluacion_medica'], 'cuatro_accion3'));
            $evm->SetCincoObjeto1(CAdminMinimental::GetMinimental($rs['idevaluacion_medica'], 'cinco_objeto1'));
            $evm->SetCincoObjeto2(CAdminMinimental::GetMinimental($rs['idevaluacion_medica'], 'cinco_objeto2'));
            $evm->SetCincoObjeto3(CAdminMinimental::GetMinimental($rs['idevaluacion_medica'], 'cinco_objeto3'));
            $evm->SetSeisDibujo(CAdminMinimental::GetMinimental($rs['idevaluacion_medica'], 'seis_dibujo'));
            //******************** FIN MINIMENTAL
        }

        // **************************************************************
        // ********************* INICIO BARTHEL *************************
        // **************************************************************

        $evm->SetPuntajeBarthel($rs['puntaje_barthel']);

        if ($rs['puntaje_barthel'] != 0 && $rs['puntaje_barthel'] != NULL) {

            $evm->SetGradoDependencia($rs['grado_dependencia']);

            $evm->SetBarthelComer(CAdminBarthel::GetBarthel($rs['idevaluacion_medica'], 'comer'));
            $evm->SetBarthelLavarse(CAdminBarthel::GetBarthel($rs['idevaluacion_medica'], 'lavarse'));
            $evm->SetBarthelVestirse(CAdminBarthel::GetBarthel($rs['idevaluacion_medica'], 'vestirse'));
            $evm->SetBarthelArreglar(CAdminBarthel::GetBarthel($rs['idevaluacion_medica'], 'arreglar'));
            $evm->SetBarthelDeposiciones(CAdminBarthel::GetBarthel($rs['idevaluacion_medica'], 'deposiciones'));
            $evm->SetBarthelMiccion(CAdminBarthel::GetBarthel($rs['idevaluacion_medica'], 'miccion'));
            $evm->SetBarthelRetrete(CAdminBarthel::GetBarthel($rs['idevaluacion_medica'], 'retrete'));
            $evm->SetBarthelTrasladarse(CAdminBarthel::GetBarthel($rs['idevaluacion_medica'], 'trasladarse'));
            $evm->SetBarthelDeambular(CAdminBarthel::GetBarthel($rs['idevaluacion_medica'], 'deambular'));
            $evm->SetBarthelEscalones(CAdminBarthel::GetBarthel($rs['idevaluacion_medica'], 'escalones'));
        }

        // **************************************************************
        // **************************************************************
        // **************************************************************

        return $evm;
    }

    public static function GetEvMedicasLista($pp) {
        $query = "select idevaluacion_medica, fecha_realizacion from evaluacion_medica where proceso_postulacion_idproceso_postulacion=" . $pp;
        $con = CDBSingleton::GetConn();
        $exito = $con->query($query);
        $a = array();
        if (CDBSingleton::RevisarExito($exito, $query)) {
            for ($i = 0; $i < $exito->numrows(); $i++) {
                $rs = $exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i] = new CEvaluacionMedica();
                $a[$i]->SetId($rs['idevaluacion_medica']);
                $a[$i]->SetFechaEvaluacion($rs['fecha_realizacion']);
            }
        }
        return $a;
    }

    public static function ActualizarEvMedica(&$evaluacio) {
        $query = "update evaluacion_medica set fecha_realizacion='" . $evaluacio->GetFechaEvaluacion() . "', consultorio='" . $evaluacio->GetConsultorio() .
                "', ultimo_control='" . $evaluacio->GetUltimoControl() . "', no_farmacologico='" . $evaluacio->GetTratamientoNoFarmacologico() . "', habito_alcohol='" . $evaluacio->GetHabitoDeAlcohol() .
                "', tiempo_detencion='" . $evaluacio->GetAlcoholDetenido() . "', deprimido=" . $evaluacio->GetDepresion() . ", nervioso=" . $evaluacio->GetNervioso() .
                ", agitacion=" . $evaluacio->GetAgitacionPsicomotora() . " , agitacion2='" . $evaluacio->GetTiempoAgitacion() . "', alteracion_memoria='" . $evaluacio->GetAlteracionesMemoria() . "', numero_caidas='" .
                $evaluacio->GetCaidasUltimoAnio() . "', fecha_ultima_caida='" . $evaluacio->GetFechaUltimaCaida() . "', consecuencias='" . $evaluacio->GetConsecuencia() . "', peso='" . $evaluacio->GetPeso() . "', talla='" .
                $evaluacio->GetTalla() . "', clasif_nutricional='" . $evaluacio->GetClasificacionNutricional() . "', alimentacion='" . $evaluacio->GetAlimentacion() . "', conciencia_vigil=" . $evaluacio->GetConcienciaVigil() . ", conciencia_orientada=" .
                $evaluacio->GetConcienciaOrientada() . ",  hidratacion='" . $evaluacio->GetHidratacion() . "', corazon='" . $evaluacio->GetCorazon() . "', pulmones='" .
                $evaluacio->GetPulmones() . "', abdomen='" . $evaluacio->GetAbdomen() . "', extremidades_sup='" . $evaluacio->GetExtremedadesSuperiores() . "', extremidades_inf='" . $evaluacio->GetExtremidadesInferiores() . "', marcha='" .
                $evaluacio->GetMarcha() . "', medica='" . $evaluacio->GetMedica() . "', salud_mental='" . $evaluacio->GetSaludMental() . "', comentarios='" . $evaluacio->GetComentarios() . "', recomendacion='" . $evaluacio->GetRecomendacion() . "', lavado=" .
                $evaluacio->GetKatzLavado() . ", vestido=" . $evaluacio->GetKatzVestido() . ", wc=" . $evaluacio->GetKatzWc() . ", movilidad=" . $evaluacio->GetKatzMovilidad() . ", continencia=" .
                $evaluacio->GetKatzContinencia() . ", alimentacion2=" . $evaluacio->GetKatzAlimentacion() . ", quien_responde=" . $evaluacio->GetQuienReponde() . ",
                donde_se_encuentra_iddonde_se_encuentra=" . CAdminSolicitudes::GetDondeSeEncuentraId($evaluacio->GetLugarResidencia()) . ", piel='" .
                $evaluacio->GetPiel() . "', funcional='" . $evaluacio->GetFuncional() . "', desc_agitacion='" . $evaluacio->GetDescripcionAgitacion() .
                "', vision='" . $evaluacio->GetVision() . "', audicion='" . $evaluacio->GetAudicion() . "', escaras='" . $evaluacio->GetEscaras() . "', minimental=" . $evaluacio->GetMinimental() . ", deterioro='" . $evaluacio->GetDeterioro() .
                "', puntaje_barthel=" . $evaluacio->GetPuntajeBarthel() . ", grado_dependencia='" . $evaluacio->GetGradoDependencia() .
                "', t_nuevaenfermedad=" . $evaluacio->GetTieneNuevaEnfermedad() . ", obs_nuevaenfermedad='" . $evaluacio->GetObsNuevaEnfermedad() .
                "', t_cirujias=" . $evaluacio->GetTieneCirugias() . ", t_alimentaria=" . $evaluacio->GetTieneAlAlimentaria() . ", t_farma=" . $evaluacio->GetTieneAlFarmacologica() . ", t_otra=" . $evaluacio->GetTieneAlOtra() . ", t_frac=" . $evaluacio->GetTieneFracturas() .
                ", t_hosp=" . $evaluacio->GetTieneHospitalizaciones() . ", t_cpe=" . $evaluacio->GetTieneCPE() . ", t_medicamentos=" . $evaluacio->GetTieneMedicamentos() . ", t_automedica=" . $evaluacio->GetTieneAutomedica() . ", t_trat_agi=" . $evaluacio->GetTieneTratAgi() .
                ", t_hos_psiqui=" . $evaluacio->GetTieneHospPsiquiatricas() . ", alimentacion_otro='" . $evaluacio->GetAlimentacionOtra() . "' where idevaluacion_medica=" . $evaluacio->GetId();
        $con = CDBSingleton::GetConn();
        $exito = $con->query($query);
        if (CDBSingleton::RevisarExito($exito, $query)) {
            $id_evm = $evaluacio->GetId();

            //   "', t_nuevaenfermedad=".$evaluacio->GetTieneNuevaEnfermedad().", obs_nuevaenfermedad='.$evaluacio->GetObsNuevaEnfermedad().
            // ***********************  MINIMENTAL *************************
            CAdminMinimental::ActualizarMinimental($evaluacio, $id_evm);
            // *************************************************************
            // ************************  BARTHEL ***************************
            CAdminBarthel::ActualizarBarthel($evaluacio, $id_evm);
            // *************************************************************
            //cirujias
            CAdminCirujias::EliminarCirujias($id_evm);
            for ($i = 0, $cir = $evaluacio->GetCirujias(); $i < count($evaluacio->GetCirujias()); $i++) {
                CAdminCirujias::IngresarCirujia($cir[$i], $id_evm);
            }
            //enfermedades
            CAdminEnfermedades::EliminarEnfermedades($id_evm);
            for ($i = 0, $enf = $evaluacio->GetEnfermedades(); $i < count($evaluacio->GetEnfermedades()); $i++) {
                CAdminEnfermedades::IngresarEnfermedadesEvMedica($enf[$i], $id_evm);
            }
            //fracturas
            CAdminFracturas::EliminarFracturas($id_evm);
            for ($i = 0, $fra = $evaluacio->GetFracturas(); $i < count($evaluacio->GetFracturas()); $i++) {
                CAdminFracturas::IngresarFractura($fra[$i], $id_evm);
            }
            //alergias
            CAdminAlergias::EliminarAlergia($id_evm);
            for ($i = 0, $farma = $evaluacio->GetFarmacologica(); $i < count($evaluacio->GetFarmacologica()); $i++) {
                CAdminAlergias::IngresarAlergia($farma[$i], $id_evm);
            }
            for ($i = 0, $alim = $evaluacio->GetAlimentaria(); $i < count($evaluacio->GetAlimentaria()); $i++) {
                CAdminAlergias::IngresarAlergia($alim[$i], $id_evm);
            }
            for ($i = 0, $otra = $evaluacio->GetOtras(); $i < count($evaluacio->GetOtras()); $i++) {
                CAdminAlergias::IngresarAlergia($otra[$i], $id_evm);
            }
            //hospitalizaciones
            CAdminHospitalizaciones::EliminarHospitalizaciones($id_evm);
            for ($i = 0, $hosp = $evaluacio->GetHospitalizaciones(); $i < count($evaluacio->GetHospitalizaciones()); $i++) {
                CAdminHospitalizaciones::IngresarHospitalizacion($hosp[$i], $id_evm);
            }
            //control especialidades
            CAdminControlEspecialidades::EliminarControlesEspecialidades($id_evm);
            for ($i = 0, $cep = $evaluacio->GetControlEspecialidades(); $i < count($evaluacio->GetControlEspecialidades()); $i++) {
                CAdminControlEspecialidades::IngresarControlEspecialidades($cep[$i], $id_evm);
            }
            //medicamentos
            CAdminMedicamentos::EliminarMedicamentos($id_evm);
            for ($i = 0, $med = $evaluacio->GetMedicamentos(); $i < count($evaluacio->GetMedicamentos()); $i++) {
                CAdminMedicamentos::IngresarMedicamentos($med[$i], $id_evm);
            }
            //habitos sueño
            CAdminHabitosSuenio::EliminarHSuenio($id_evm);
            for ($i = 0, $hsu = $evaluacio->GetHabitoSuenio(); $i < count($evaluacio->GetHabitoSuenio()); $i++) {
                CAdminHabitosSuenio::IngresarHSuenioEvMedica($hsu[$i], $id_evm);
            }
            //tart agi psico
            CAdminTratamientoAgitacion::EliminarTratAgitaciones($id_evm);
            for ($i = 0, $trata = $evaluacio->GetTratamientos(); $i < count($evaluacio->GetTratamientos()); $i++) {
                CAdminTratamientoAgitacion::IngresarTratAgitaciones($trata[$i], $id_evm);
            }

            //automedica
            CAdminAutomedica::EliminarMedicamentos($id_evm);
            for ($i = 0, $auto = $evaluacio->GetAutomedica(); $i < count($evaluacio->GetAutomedica()); $i++) {
                CAdminAutomedica::IngresarAutomedica($auto[$i], $id_evm);
            }
            //hospitalizaciones psiquiatricas
            CAdminHospitalizacionesPsiquiatricas::EliminarHospitalizaciones($id_evm);
            for ($i = 0, $hpsi = $evaluacio->GetHospitalizacionesSiquiatricas(); $i < count($evaluacio->GetHospitalizacionesSiquiatricas()); $i++) {
                CAdminHospitalizacionesPsiquiatricas::IngresarHospitalizacionPsi($hpsi[$i], $id_evm);
            }
            $evm = self::GetEvMedica($evaluacio->GetId());
            $pp = CAdminProcesoPostulacion::GetProcesoPostulacionIdProceso($evm->GetProcesoPostulacion());
            $log = new CLog();
            $log->SetFecha(date("Y-m-d H:i:s"));
            $log->SetEvento("Actualizacion de Ev. Medica");
            $log->SetAdultoMayor($pp->GetIdAdultoMayor());
            $log->SetObservaciones("Evaluacion Medica id=" . $evaluacio->GetId());
            $log->SetUsuario(CAdminSesion::NombreUsuario());
            CAdminLog::Insertar($log);
        }
    }

    /* funciones que solo sirven para arreglar katz y habitos de sueño */

    public static function GetEvaluacionesMedica_1() {
        $query = "select suenio, idevaluacion_medica from evaluacion_medica where 1";
        $con = CDBSingleton::GetConn();
        $exito = $con->query($query);
        if (CDBSingleton::RevisarExito($exito, $query)) {
            $a = array();
            for ($i = 0; $i < $exito->numrows(); $i++) {
                $rs = $exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i] = new CEvaluacionMedica();
                $a[$i]->SetId($rs['idevaluacion_medica']);
                $a[$i]->SetHabitoSuenio($rs['suenio']);
            }
            return $a;
        }
    }

    public static function GetEvaluacionesMedica_2() {
        $query = "select idevaluacion_medica,recomendacion ,alimentacion2, continencia, movilidad, wc, vestido, lavado, proceso_postulacion_idproceso_postulacion from evaluacion_medica where 1 order by fecha_realizacion asc";
        $con = CDBSingleton::GetConn();
        $exito = $con->query($query);
        if (CDBSingleton::RevisarExito($exito, $query)) {
            $a = array();
            for ($i = 0; $i < $exito->numrows(); $i++) {
                $rs = $exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i] = new CEvaluacionMedica();
                $a[$i]->SetId($rs['idevaluacion_medica']);
                $a[$i]->SetKatzAlimentacion($rs['alimentacion2']);
                $a[$i]->SetKatzContinencia($rs['continencia']);
                $a[$i]->SetKatzMovilidad($rs['movilidad']);
                $a[$i]->SetKatzWc($rs['wc']);
                $a[$i]->SetKatzVestido($rs['vestido']);
                $a[$i]->SetKatzLavado($rs['lavado']);
                $a[$i]->SetProcesoPostulacion($rs['proceso_postulacion_idproceso_postulacion']);
                $a[$i]->SetRecomendacion($rs['recomendacion']);
            }
            return $a;
        }
    }

}

?>