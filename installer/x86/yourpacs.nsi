;Include Modern UI
!include "MUI2.nsh"


Name "Yourpacs"

; The file to write
OutFile "yourpacs.exe"

!define MUI_ICON "logo.ico"

; The default installation directory
; InstallDir $PROGRAMFILES\Yourpacs
InstallDir C:\Yourpacs

; Request application privileges for Windows Vista
RequestExecutionLevel admin

;--------------------------------
; Pages
!define MUI_ABORTWARNING
!insertmacro MUI_PAGE_LICENSE "${NSISDIR}\Docs\Modern UI\License.txt"
!insertmacro MUI_PAGE_COMPONENTS
;!insertmacro MUI_PAGE_DIRECTORY
!insertmacro MUI_PAGE_INSTFILES
!insertmacro MUI_UNPAGE_CONFIRM
!insertmacro MUI_UNPAGE_INSTFILES
!insertmacro MUI_LANGUAGE "English"

Var OpenVPNError
Var ClearCanvasError


; Usage
; 1 Call SetupDotNetSectionIfNeeded from .onInit function
;   This function will check if the required version 
;   or higher version of the .NETFramework is installed.
;   If .NET is NOT installed the section which installs dotnetfx is selected.
;   If .NET is installed the section which installs dotnetfx is unselected.
 
#!define SF_USELECTED  0
#!define SF_SELECTED   1
#!define SF_SECGRP     2
#!define SF_BOLD       8
#!define SF_RO         16
#!define SF_EXPAND     32
###############################
 
!define DOT_MAJOR 2
!define DOT_MINOR 0
 
!macro SecSelect SecId
  Push $0
  IntOp $0 ${SF_SELECTED} | ${SF_RO}
  SectionSetFlags ${SecId} $0
  SectionSetInstTypes ${SecId} 1
  Pop $0
!macroend
 
!define SelectSection '!insertmacro SecSelect'
#################################
 
!macro SecUnSelect SecId
  Push $0
  IntOp $0 ${SF_USELECTED} | ${SF_RO}
  SectionSetFlags ${SecId} $0
  SectionSetText  ${SecId} ""
  Pop $0
!macroend
 
!define UnSelectSection '!insertmacro SecUnSelect'
###################################
 
!macro SecExtract SecId
  Push $0
  IntOp $0 ${SF_USELECTED} | ${SF_RO}
  SectionSetFlags ${SecId} $0
  SectionSetInstTypes ${SecId} 2
  Pop $0
!macroend
 
!define SetSectionExtract '!insertmacro SecExtract'
###################################
 
!macro Groups GroupId
  Push $0
  SectionGetFlags ${GroupId} $0
  IntOp $0 $0 | ${SF_RO}
  IntOp $0 $0 ^ ${SF_BOLD}
  IntOp $0 $0 ^ ${SF_EXPAND}
  SectionSetFlags ${GroupId} $0
  Pop $0
!macroend
 
!define SetSectionGroup "!insertmacro Groups"
####################################
 
!macro GroupRO GroupId
  Push $0
  IntOp $0 ${SF_SECGRP} | ${SF_RO}
  SectionSetFlags ${GroupId} $0
  Pop $0
!macroend
 
!define MakeGroupReadOnly '!insertmacro GroupRO'
 
Function SetupDotNetSectionIfNeeded
 
  StrCpy $0 "0"
  StrCpy $1 "SOFTWARE\Microsoft\.NETFramework" ;registry entry to look in.
  StrCpy $2 0
 
  StartEnum:
    ;Enumerate the versions installed.
    EnumRegKey $3 HKLM "$1\policy" $2
 
    ;If we don't find any versions installed, it's not here.
    StrCmp $3 "" noDotNet notEmpty
 
    ;We found something.
    notEmpty:
      ;Find out if the RegKey starts with 'v'.  
      ;If it doesn't, goto the next key.
      StrCpy $4 $3 1 0
      StrCmp $4 "v" +1 goNext
      StrCpy $4 $3 1 1
 
      ;It starts with 'v'.  Now check to see how the installed major version
      ;relates to our required major version.
      ;If it's equal check the minor version, if it's greater, 
      ;we found a good RegKey.
      IntCmp $4 ${DOT_MAJOR} +1 goNext yesDotNetReg
      ;Check the minor version.  If it's equal or greater to our requested 
      ;version then we're good.
      StrCpy $4 $3 1 3
      IntCmp $4 ${DOT_MINOR} yesDotNetReg goNext yesDotNetReg
 
    goNext:
      ;Go to the next RegKey.
      IntOp $2 $2 + 1
      goto StartEnum
 
  yesDotNetReg:
    ;Now that we've found a good RegKey, let's make sure it's actually
    ;installed by getting the install path and checking to see if the 
    ;mscorlib.dll exists.
    EnumRegValue $2 HKLM "$1\policy\$3" 0
    ;$2 should equal whatever comes after the major and minor versions 
    ;(ie, v1.1.4322)
    StrCmp $2 "" noDotNet
    ReadRegStr $4 HKLM $1 "InstallRoot"
    ;Hopefully the install root isn't empty.
    StrCmp $4 "" noDotNet
    ;build the actuall directory path to mscorlib.dll.
    StrCpy $4 "$4$3.$2\mscorlib.dll"
    IfFileExists $4 yesDotNet noDotNet
 
  noDotNet:
    ${SelectSection} ${SECDOTNET}
    goto done
 
  yesDotNet:
    ;Everything checks out.  Go on with the rest of the installation.
    ${UnSelectSection} ${SECDOTNET}
    goto done
 
  done:
    ;All done.
 
FunctionEnd
 
!define BASE_URL http://download.microsoft.com/download
; English
!define URL_DOTNET "${BASE_URL}/4/d/a/4da3a5fa-ee6a-42b8-8bfa-ea5c4a458a7d/dotnetfx3setup.exe"
 
 
;Var "LANGUAGE_DLL_TITLE"
;Var "LANGUAGE_DLL_INFO"
;Var "URL_DOTNET"
;Var "OSLANGUAGE"
Var "DOTNET_RETURN_CODE"
 
LangString DESC_REMAINING ${LANG_ENGLISH} " (%d %s%s remaining)"
LangString DESC_PROGRESS ${LANG_ENGLISH} "%d.%01dkB/s" ;"%dkB (%d%%) of %dkB @ %d.%01dkB/s"
LangString DESC_PLURAL ${LANG_ENGLISH} "s"
LangString DESC_HOUR ${LANG_ENGLISH} "hour"
LangString DESC_MINUTE ${LANG_ENGLISH} "minute"
LangString DESC_SECOND ${LANG_ENGLISH} "second"
LangString DESC_CONNECTING ${LANG_ENGLISH} "Connecting..."
LangString DESC_DOWNLOADING ${LANG_ENGLISH} "Downloading %s"
LangString DESC_SHORTDOTNET ${LANG_ENGLISH} "Microsoft .Net Framework"
LangString DESC_LONGDOTNET ${LANG_ENGLISH} "Microsoft .Net Framework"
LangString DESC_DOTNET_DECISION ${LANG_ENGLISH} "$(DESC_SHORTDOTNET) is required.$\nIt is strongly \
  advised that you install$\n$(DESC_SHORTDOTNET) before continuing.$\nIf you choose to continue, \
  you will need to connect$\nto the internet before proceeding.$\nWould you like to continue with \
  the installation?"
LangString SEC_DOTNET ${LANG_ENGLISH} "$(DESC_SHORTDOTNET) "
LangString DESC_INSTALLING ${LANG_ENGLISH} "Installing"
LangString DESC_DOWNLOADING1 ${LANG_ENGLISH} "Downloading"
LangString DESC_DOWNLOADFAILED ${LANG_ENGLISH} "Download Failed:"
LangString ERROR_DOTNET_DUPLICATE_INSTANCE ${LANG_ENGLISH} "The $(DESC_SHORTDOTNET) Installer is \
  already running."
LangString ERROR_NOT_ADMINISTRATOR ${LANG_ENGLISH} "You are not administrator"
LangString ERROR_INVALID_PLATFORM ${LANG_ENGLISH} "Invalid plataform"
LangString DESC_DOTNET_TIMEOUT ${LANG_ENGLISH} "The installation of the $(DESC_SHORTDOTNET) \
  has timed out."
LangString ERROR_DOTNET_INVALID_PATH ${LANG_ENGLISH} "The $(DESC_SHORTDOTNET) Installation$\n\
  was not found in the following location:$\n"
LangString ERROR_DOTNET_FATAL ${LANG_ENGLISH} "A fatal error occurred during the installation$\n\
  of the $(DESC_SHORTDOTNET)."
LangString FAILED_DOTNET_INSTALL ${LANG_ENGLISH} "The installation of Yourpacs will$\n\
  continue. However, it may not function properly$\nuntil $(DESC_SHORTDOTNET)$\nis installed."
 
 
Section $(SEC_DOTNET) SECDOTNET
    SectionIn RO
    IfSilent lbl_IsSilent
    !define DOTNETFILESDIR "Common\Files\MSNET"
    StrCpy $DOTNET_RETURN_CODE "0"
!ifdef DOTNET_ONCD_1033
    ;StrCmp "$OSLANGUAGE" "1033" 0 lbl_Not1033
    SetOutPath "$PLUGINSDIR"
    file /r "${DOTNETFILESDIR}\dotnetfx1033.exe"
    DetailPrint "$(DESC_INSTALLING) $(DESC_SHORTDOTNET)..."
    Banner::show /NOUNLOAD "$(DESC_INSTALLING) $(DESC_SHORTDOTNET)..."
    nsExec::ExecToStack '"$PLUGINSDIR\dotnetfx1033.exe" /q /c:"install.exe /noaspupgrade /q"'
    pop $DOTNET_RETURN_CODE
    Banner::destroy
    SetRebootFlag true
    Goto lbl_NoDownloadRequired
    lbl_Not1033:
!endif
; Insert Other language blocks here
 
    ; the following Goto and Label is for consistencey.
    Goto lbl_DownloadRequired
    lbl_DownloadRequired:
    DetailPrint "$(DESC_DOWNLOADING1) $(DESC_SHORTDOTNET)..."
    ;MessageBox MB_ICONEXCLAMATION|MB_YESNO|MB_DEFBUTTON2 "$(DESC_DOTNET_DECISION)" /SD IDNO \
    ;  IDYES +2 IDNO 0
    ;Abort
    ; "Downloading Microsoft .Net Framework"
    AddSize 153600
    nsisdl::download /TRANSLATE "$(DESC_DOWNLOADING)" "$(DESC_CONNECTING)" \
       "$(DESC_SECOND)" "$(DESC_MINUTE)" "$(DESC_HOUR)" "$(DESC_PLURAL)" \
       "$(DESC_PROGRESS)" "$(DESC_REMAINING)" \
       /TIMEOUT=30000 "${URL_DOTNET}" "$PLUGINSDIR\dotnetfx.exe"
    Pop $0
    StrCmp "$0" "success" lbl_continue
    DetailPrint "$(DESC_DOWNLOADFAILED) $0"
    Abort
 
    lbl_continue:
      DetailPrint "$(DESC_INSTALLING) $(DESC_SHORTDOTNET)..."
      Banner::show /NOUNLOAD "$(DESC_INSTALLING) $(DESC_SHORTDOTNET)..."
      nsExec::ExecToStack '"$PLUGINSDIR\dotnetfx.exe" /q /c:"install.exe /noaspupgrade /q"'
      pop $DOTNET_RETURN_CODE
      Banner::destroy
      SetRebootFlag true
      ; silence the compiler
      Goto lbl_NoDownloadRequired
      lbl_NoDownloadRequired:
 
      ; obtain any error code and inform the user ($DOTNET_RETURN_CODE)
      ; If nsExec is unable to execute the process,
      ; it will return "error"
      ; If the process timed out it will return "timeout"
      ; else it will return the return code from the executed process.
      StrCmp "$DOTNET_RETURN_CODE" "" lbl_NoError
      StrCmp "$DOTNET_RETURN_CODE" "0" lbl_NoError
      StrCmp "$DOTNET_RETURN_CODE" "3010" lbl_NoError
      StrCmp "$DOTNET_RETURN_CODE" "8192" lbl_NoError
      StrCmp "$DOTNET_RETURN_CODE" "error" lbl_Error
      StrCmp "$DOTNET_RETURN_CODE" "timeout" lbl_TimeOut
      ; It's a .Net Error
      StrCmp "$DOTNET_RETURN_CODE" "4101" lbl_Error_DuplicateInstance
      StrCmp "$DOTNET_RETURN_CODE" "4097" lbl_Error_NotAdministrator
      StrCmp "$DOTNET_RETURN_CODE" "1633" lbl_Error_InvalidPlatform lbl_FatalError
      ; all others are fatal
 
    lbl_Error_DuplicateInstance:
    DetailPrint "$(ERROR_DOTNET_DUPLICATE_INSTANCE)"
    GoTo lbl_Done
 
    lbl_Error_NotAdministrator:
    DetailPrint "$(ERROR_NOT_ADMINISTRATOR)"
    GoTo lbl_Done
 
    lbl_Error_InvalidPlatform:
    DetailPrint "$(ERROR_INVALID_PLATFORM)"
    GoTo lbl_Done
 
    lbl_TimeOut:
    DetailPrint "$(DESC_DOTNET_TIMEOUT)"
    GoTo lbl_Done
 
    lbl_Error:
    DetailPrint "$(ERROR_DOTNET_INVALID_PATH)"
    GoTo lbl_Done
 
    lbl_FatalError:
    DetailPrint "$(ERROR_DOTNET_FATAL)[$DOTNET_RETURN_CODE]"
    GoTo lbl_Done
 
    lbl_Done:
    DetailPrint "$(FAILED_DOTNET_INSTALL)"
    lbl_NoError:
    lbl_IsSilent:
SectionEnd
 


Function .onInit
    ;StrCpy $URL_DOTNET "${URL_DOTNET_1033}"
	;StrCpy $OSLANGUAGE "1033"
	Call SetupDotNetSectionIfNeeded
FunctionEnd

;Page components
;Page directory
;Page instfiles
;UninstPage uninstConfirm
;UninstPage instfiles

; The stuff to install
Section "Yourpacs base" SecBase

  SectionIn RO
  
  ; Set output path to the installation directory.
  SetOutPath $INSTDIR

  
  ; Fitxers a instal·lar
  File /r "files"
  
  ; Write the installation path into the registry
  WriteRegStr HKLM SOFTWARE\Yourpacs "Install_Dir" "$INSTDIR"
  
  ; Write the uninstall keys for Windows
  WriteRegStr HKLM "Software\Microsoft\Windows\CurrentVersion\Uninstall\Yourpacs" "DisplayName" "Yourpacs"
  WriteRegStr HKLM "Software\Microsoft\Windows\CurrentVersion\Uninstall\Yourpacs" "UninstallString" '"$INSTDIR\uninstall.exe"'
  WriteRegDWORD HKLM "Software\Microsoft\Windows\CurrentVersion\Uninstall\Yourpacs" "NoModify" 1
  WriteRegDWORD HKLM "Software\Microsoft\Windows\CurrentVersion\Uninstall\Yourpacs" "NoRepair" 1
  WriteUninstaller "uninstall.exe"
SectionEnd



;--------------------------------
;Descriptions
Section "OpenVPN (required)" SecOpenVPN
 SectionIn RO
 DetailPrint "Installing OpenVPN (it can take some minutes)."
 ExecWait '"$INSTDIR\files\openvpn-2.1.1-install.exe" /S ' $OpenVPNError
 CopyFiles "$INSTDIR\files\ca.cer" "$PROGRAMFILES\Openvpn\config\"
 CopyFiles "$INSTDIR\files\yourpacs.cer" "$PROGRAMFILES\Openvpn\config\"
 CopyFiles "$INSTDIR\files\yourpacs.key" "$PROGRAMFILES\Openvpn\config\"
 CopyFiles "$INSTDIR\files\yourpacs.ovpn" "$PROGRAMFILES\Openvpn\config\"
 DetailPrint "Finished OpenVPN Setup"
 
SectionEnd

Section "ClearCanvas Viewer (a viewer is required)" SecClearCanvas
 SectionIn RO
 DetailPrint "Installing ClearCanvas Viewer (it can take some minutes)."
 ExecWait '"$INSTDIR\files\CCWorkstation2.0SP1.exe" /S /D=C:\Yourpacs\Clearcanvas' $ClearCanvasError
 CopyFiles "$INSTDIR\files\ClearCanvas.Server.ShredHostService.exe.config" "C:\Yourpacs\Clearcanvas\"
 CopyFiles "$INSTDIR\files\DicomAEServers.xml" "C:\Yourpacs\Clearcanvas\"
 DetailPrint "Finished ClearCanvas Setup"
 
SectionEnd

Section "Configuration tool (required)" SecConfig
	SectionIn RO
    SetRebootFlag true
	DetailPrint "Configuring yourpacs account"
	ExecWait '"$INSTDIR\files\configuration.exe"' 
	DetailPrint "Finished configuring yourpacs account"
	DetailPrint "Adding firewall rules"
	SimpleFC::AddApplication "OpenVPN" "C:\Yourpacs\Openvpn\bin\openvpn-gui-1.0.3.exe" 0 2 "" 1
    SimpleFC::AddApplication "ClearCanvas" "C:\Yourpacs\Clearcanvas\ClearCanvas.Desktop.Executable.exe" 0 2 "" 1
	SimpleFC::AddApplication "ClearCanvas Service" "C:\Yourpacs\Clearcanvas\ClearCanvas.Server.ShredHostService.exe" 0 2 "" 1
	WriteRegStr HKLM "Software\Microsoft\Windows NT\CurrentVersion\AppCompatFlags\layers" "$PROGRAMFILES\Openvpn\bin\openvpn-gui-1.0.3.exe" "RUNASADMIN"
SectionEnd
; Uninstaller
  
Section "Uninstall"
  
  ; Remove registry keys
  DeleteRegKey HKLM "Software\Microsoft\Windows\CurrentVersion\Uninstall\Yourpacs"
  DeleteRegKey HKLM SOFTWARE\Yourpacs

  ; Remove files and uninstaller
  Delete $INSTDIR\yourpacs.nsi
  Delete $INSTDIR\uninstall.exe
  Delete "$INSTDIR\files\*.*"
  ; Remove directories used
  RMDir "$INSTDIR\files\"
  RMDir "$INSTDIR\"


SectionEnd

;Language strings
LangString DESC_SecBase ${LANG_ENGLISH} "YourPACS Base files to configure other software"
LangString DESC_SecOpenVPN ${LANG_ENGLISH} "The VPN software required to connect securely to YourPACS"
LangString DESC_SecClearCanvas ${LANG_ENGLISH} "A OpenSource DICOM viewer able to use YourPACS"
LangString DESC_SecConfig ${LANG_ENGLISH} "The configuration tool for YourPACS and ClearCanvas"




;Assign language strings to sections
!insertmacro MUI_FUNCTION_DESCRIPTION_BEGIN
  !insertmacro MUI_DESCRIPTION_TEXT ${SECDOTNET} $(DESC_LONGDOTNET)
  !insertmacro MUI_DESCRIPTION_TEXT ${SecBase} $(DESC_SecBase)
  !insertmacro MUI_DESCRIPTION_TEXT ${SecOpenVPN} $(DESC_SecOpenVPN)
  !insertmacro MUI_DESCRIPTION_TEXT ${SecClearCanvas} $(DESC_SecClearCanvas)
  !insertmacro MUI_DESCRIPTION_TEXT ${SecConfig} $(DESC_SecConfig)
!insertmacro MUI_FUNCTION_DESCRIPTION_END
