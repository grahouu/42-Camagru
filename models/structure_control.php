<?php


function get_structures_controls() {  

$structures_controls=array(
"morning" => array (
    "etat_ordi"  => array("libelle" => "SCOM - Etat des ordinateurs:", "type_resultat" => "boolean"),
    "etat_agent" => array("libelle" => "SCOM - Etat des agents:", "type_resultat" => "boolean"),
    "acces_internet" => array("libelle" => "Acces internet:", "type_resultat" => "boolean"),
    "acces_messagerie" => array("libelle" => "Acces messagerie:", "type_resultat" => "boolean"),
    "acces_appli" => array("libelle" => "Acces application:", "type_resultat" => "boolean"),
    
	
    "job-Agences_différentielle_quotidienne" => array("libelle" => "Job - Agences différentielle quotidienne :", "type_resultat" => "boolean"),
    "job-Lundi_au_Vendredi_Hôtel_du_département" => array("libelle" => "Job - Lundi au Vendredi Hôtel du département  :", "type_resultat" => "boolean"),
    "job-Sauvegarde_Archive_Mail" => array("libelle" => "Job - Sauvegarde Archive Mail  :", "type_resultat" => "boolean"),
    "job-Sauvegarde_Exchange_Disque" => array("libelle" => "Job - Sauvegarde Exchange Disque :", "type_resultat" => "boolean"),
    "job-Sauvegarde_Exchange_LTO_DECS" => array("libelle" => "Job - Sauvegarde Exchange LTO DECS :", "type_resultat" => "boolean"),
    "job-Sauvegarde_Exchange_LTO_DRESS" => array("libelle" => "Job - Sauvegarde Exchange LTO DRESS :", "type_resultat" => "boolean"),
    "job-Sauvegarde_Exchange_LTO_Tout_sauf_DECS" => array("libelle" => "Job - Sauvegarde Exchange LTO Tout sauf DECS  :", "type_resultat" => "boolean"),
    "job-Sauvegarde_disque_Hyper-V" => array("libelle" => "Job - Sauvegarde disque Hyper-V :", "type_resultat" => "boolean"),
    "job-Agences_complète_semaine_impaire" => array("libelle" => "Job - Agences complète semaine impaire :", "type_resultat" => "boolean"),
    "job-Agences_complète_semaine_paire" => array("libelle" => "Job - Agences complète semaine paire :", "type_resultat" => "boolean"),
    "job-Samedi_Site_Hôtel_du_département" => array("libelle" => "Job - Samedi Site Hôtel du département  :", "type_resultat" => "boolean"),
    "job-Sauvegarde_Exchange LTO BASE" => array("libelle" => "Job - Sauvegarde Exchange LTO BASE :", "type_resultat" => "boolean"),
    
    
    "s1-montardon" => array("libelle" => "Controle des sauvegarde s1-montardon:", "type_resultat" => "boolean"),
    "s1-archives" => array("libelle" => "Controle des sauvegarde s1-archives:", "type_resultat" => "boolean"),
    "s1-nive" => array("libelle" => "Controle des sauvegarde s1-nive:", "type_resultat" => "boolean"),
    "s1-irissarry" => array("libelle" => "Controle des sauvegarde s1-irissarry:", "type_resultat" => "boolean"),
    "s1-parcroutier" => array("libelle" => "Controle des sauvegarde s1-parcroutier:", "type_resultat" => "boolean"),
    "s1-mdph" => array("libelle" => "Controle des sauvegarde s1-mdph:", "type_resultat" => "boolean"),
    
    "emailxtender-journal_evenements_OTG" => array("libelle" => "emailxtender - Journal d'évènements OTG:", "type_resultat" => "boolean"),
    "emailxtender-files_MSMQ" => array("libelle" => "emailxtender - Files MSMQ:", "type_resultat" => "boolean"),
    "emailxtender-etat_des_volumes_et_index" => array("libelle" => "emailxtender - Etat des volumes et des index:", "type_resultat" => "boolean"),
    "emailxtender-etat_des_services" => array("libelle" => "emailxtender - Etat des services:", "type_resultat" => "boolean"),
    "emailxtender-espaces_disques" => array("libelle" => "emailxtender - Espaces disques:", "type_resultat" => "boolean"),
    "emailxtender-logs_emailxtract" => array("libelle" => "emailxtender - Logs emailxtract:", "type_resultat" => "boolean"),
    
    "nb_comptes" => array("libelle" => "Vérification des comptes vérouillés:", "type_resultat" => "boolean"),
    ),
    
"afternoon" => array (
    "etat_ordi"  => array("libelle" => "SCOM - Etat des ordinateurs:", "type_resultat" => "boolean"),
    "etat_agent" => array("libelle" => "SCOM - Etat des agents:", "type_resultat" => "boolean"),
    ),
	
"server" => array (
	"journaux"  => array("libelle" => "Journaux d'évènements", "type_resultat" => "boolean"),
    "service"  => array("libelle" => "Service", "type_resultat" => "boolean"),
    "tests_dns" => array("libelle" => "Tests DNS", "type_resultat" => "boolean"),
    "etat_imp" => array("libelle" => "Etat du spooler d'impression", "type_resultat" => "boolean"),
    "nb_imp" => array("libelle" => "Imprimantes en érreurs", "type_resultat" => "boolean"),
    "verif_shadows" => array("libelle" => "Vérification du Shadows Copy", "type_resultat" => "boolean"),
    "verif_onduleur" => array("libelle" => "Vérification de l'onduleur", "type_resultat" => "boolean"),
    "verif_horaires" => array("libelle" => "Vérification des synchronisations horaires", "type_resultat" => "boolean"),
    ),
	
"scheduled_tasks" => array (
	"Verif_taches_plan"  => array("libelle" => "Vérification des taches planifiées", "type_resultat" => "boolean"),
    ));
    
  return $structures_controls;
}

?>