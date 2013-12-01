<?php
/**
 * This file is part of Noxgame
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * Copyright (c) 2012-Present, mandalorien
 * All rights reserved.
 *=========================================================
  _   _                                     
 | \ | |                                    
 |  \| | _____  ____ _  __ _ _ __ ___   ___ 
 | . ` |/ _ \ \/ / _` |/ _` | '_ ` _ \ / _ \
 | |\  | (_) >  < (_| | (_| | | | | | |  __/
 |_| \_|\___/_/\_\__, |\__,_|_| |_| |_|\___|
                  __/ |                     
                 |___/                                                                             
 *=========================================================
 *
 */
 
define('BATIMENT','functions/Batiment/');
define('DEFENSE','functions/defense/');
define('GALAXIE','functions/Galaxie/');
define('ITEM','functions/item/');
define('MISSION','functions/Mission/');
define('RECHERCHE','functions/Recherche/');
define('VAISSEAU','functions/vaisseau/');

include('LogFunction.'.PHPEXT);
// Batiment
include(BATIMENT.'AddBuildingToQueue.'.PHPEXT);
include(BATIMENT.'BatimentBuildingPage.'.PHPEXT);
include(BATIMENT.'BuildingSavePlanetRecord.'.PHPEXT);
include(BATIMENT.'BuildingSaveUserRecord.'.PHPEXT);
include(BATIMENT.'CancelBuildingFromQueue.'.PHPEXT);
include(BATIMENT.'CheckPlanetBuildingQueue.'.PHPEXT);
include(BATIMENT.'CheckPlanetUsedFields.'.PHPEXT);
include(BATIMENT.'ElementBuildListQueue.'.PHPEXT);
include(BATIMENT.'FinishBuildingFromQueue.'.PHPEXT);
include(BATIMENT.'InsertBuildListScript.'.PHPEXT);
include(BATIMENT.'RemoveBuildingFromQueue.'.PHPEXT);
include(BATIMENT.'SetNextQueueElementOnTop.'.PHPEXT);
include(BATIMENT.'ShowBuildingQueue.'.PHPEXT);
include(BATIMENT.'UpdatePlanetBatimentQueueList.'.PHPEXT);

//defense
include(DEFENSE.'DefensesBuildingPage.'.PHPEXT);
include(DEFENSE.'DefenseBuildListBox.'.PHPEXT);
include(DEFENSE.'FinishldefFromQueue.'.PHPEXT);
include(DEFENSE.'HandleDefenseBuildingQueue.'.PHPEXT);

// galaxie
include(GALAXIE.'GalaxyCheckFunctions.'.PHPEXT);
include(GALAXIE.'GalaxyLegendPopup.'.PHPEXT);
include(GALAXIE.'GalaxyRowActions.'.PHPEXT);
include(GALAXIE.'GalaxyRowAlly.'.PHPEXT);
include(GALAXIE.'GalaxyRowDebris.'.PHPEXT);
include(GALAXIE.'GalaxyRowMoon.'.PHPEXT);
include(GALAXIE.'GalaxyRowPlanet.'.PHPEXT);
include(GALAXIE.'GalaxyRowPlanetName.'.PHPEXT);
include(GALAXIE.'GalaxyRowPos.'.PHPEXT);
include(GALAXIE.'GalaxyRowUser.'.PHPEXT);
include(GALAXIE.'InsertGalaxyScripts.'.PHPEXT);
include(GALAXIE.'ShowGalaxyFooter.'.PHPEXT);
include(GALAXIE.'ShowGalaxyMISelector.'.PHPEXT);
include(GALAXIE.'ShowGalaxyRows.'.PHPEXT);
include(GALAXIE.'ShowGalaxySelector.'.PHPEXT);
include(GALAXIE.'ShowGalaxyTitles.'.PHPEXT);


//objet
include(ITEM.'ItemBuildingPage.'.PHPEXT);
include(ITEM.'ItemBuildListBox.'.PHPEXT);
include(ITEM.'FinishItemFromQueue.'.PHPEXT);
include(ITEM.'HandleItemBuildingQueue.'.PHPEXT);

// Mission
include(MISSION.'FlyingFleetHandler.'.PHPEXT);
include(MISSION.'MissionCaseAttack.'.PHPEXT);
include(MISSION.'calculateAKSSteal.'.PHPEXT);
include(MISSION.'MissionCaseStay.'.PHPEXT);
include(MISSION.'MissionCaseStayAlly.'.PHPEXT);
include(MISSION.'MissionCaseTransport.'.PHPEXT);
include(MISSION.'MissionCaseSpy.'.PHPEXT);
include(MISSION.'MissionCaseRecycling.'.PHPEXT);
include(MISSION.'MissionCaseDestruction.'.PHPEXT);
include(MISSION.'MissionCaseColonisation.'.PHPEXT);
include(MISSION.'MissionCaseOccultation.'.PHPEXT);
include(MISSION.'MissionCaseExpedition.'.PHPEXT);

//Recherche
include(RECHERCHE.'RechercheBuildingPage.'.PHPEXT);

include(RECHERCHE.'AddRechercheToQueue.'.PHPEXT);
include(RECHERCHE.'CancelRechercheFromQueue.'.PHPEXT);
include(RECHERCHE.'CheckPlanetRechercheQueue.'.PHPEXT);
include(RECHERCHE.'ElementRechercheListQueue.'.PHPEXT);
include(RECHERCHE.'FinishRechercheFromQueue.'.PHPEXT);
include(RECHERCHE.'InsertRechercheListScript.'.PHPEXT);
include(RECHERCHE.'RechercheSaveUserRecord.'.PHPEXT);
include(RECHERCHE.'RemoveRechercheFromQueue.'.PHPEXT);
include(RECHERCHE.'SetNextQueueElementRechercheOnTop.'.PHPEXT);
include(RECHERCHE.'ShowRechercheQueue.'.PHPEXT);
include(RECHERCHE.'UpdatePlanetRechercheQueueList.'.PHPEXT);

// vaisseau
include(VAISSEAU.'FleetBuildingPage.'.PHPEXT);
include(VAISSEAU.'FleetBuildListBox.'.PHPEXT);
include(VAISSEAU.'FinishshipFromQueue.'.PHPEXT);
include(VAISSEAU.'HandleFleetBuildingQueue.'.PHPEXT);

//simulateur de combat
include('functions/SimuleCombat.'.PHPEXT);
include('functions/calculateAttack.'.PHPEXT);
include('functions/calculateAttack2.'.PHPEXT);
include('functions/formatCR.'.PHPEXT);

//divers
include('functions/AbandonColony.'.PHPEXT);
include('functions/BBcodeFunction.'.PHPEXT);
include('functions/BuildFleetEventTable.'.PHPEXT);
include('functions/BuildFlyingFleetTable.'.PHPEXT);
include('functions/CancelElementFromQueue.'.PHPEXT);
include('functions/CheckCookies.'.PHPEXT);
include('functions/CheckInputStrings.'.PHPEXT);
include('functions/ChekUser.'.PHPEXT);
include('functions/CreateOneMoonRecord.'.PHPEXT);
include('functions/CreateOnePlanetRecord.'.PHPEXT);
include('functions/DeleteSelectedUser.'.PHPEXT);
include('functions/GetBuildingPrice.'.PHPEXT);
include('functions/GetBuildingTime.'.PHPEXT);
include('functions/GetBuildingTimeLevel.'.PHPEXT);
include('functions/GetElementPrice.'.PHPEXT);
include('functions/GetElementRessources.'.PHPEXT);
include('functions/GetMaxConstructibleElements.'.PHPEXT);
include('functions/GetRestPrice.'.PHPEXT);
include('functions/GetRestTime.'.PHPEXT);
include('functions/InsertJavaScriptChronoApplet.'.PHPEXT);
include('functions/IsElementBuyable.'.PHPEXT);
include('functions/IsOfficierAccessible.'.PHPEXT);
include('functions/IsTechnologieAccessible.'.PHPEXT);
include('functions/IsVacationMode.'.PHPEXT);
include('functions/MessageForm.'.PHPEXT);
include('functions/PlanetResourceUpdate.'.PHPEXT);
include('functions/RestoreFleetToPlanet.'.PHPEXT);
include('functions/RevisionTime.'.PHPEXT);
include('functions/SendNewPassword.'.PHPEXT);
include('functions/SendSimpleMessage.'.PHPEXT);
include('functions/SetSelectedPlanet.'.PHPEXT);


include('functions/ShowLeftMenu.'.PHPEXT);
include('functions/ShowFleet.'.PHPEXT);
include('functions/ShowPanel.'.PHPEXT);
include('functions/ShowTopNavigationBar.'.PHPEXT);
include('functions/ShowTopPlanets.'.PHPEXT);
include('functions/typeplanets.'.PHPEXT);

include('functions/SortUserPlanets.'.PHPEXT);
include('functions/SpyTarget.'.PHPEXT);
include('functions/StoreGoodsToPlanet.'.PHPEXT);
// unique
include('functions/ResetThisFuckingCheater.'.PHPEXT);



?>
