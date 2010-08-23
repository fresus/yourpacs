;Include Modern UI
!include "MUI2.nsh"


Name "Yourpacs"

; The file to write
OutFile "yourpacs.exe"

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
 DetailPrint "Installing OpenVPN..."
 ExecWait '"$INSTDIR\files\openvpn-2.1.1-install.exe" /S ' $OpenVPNError
 CopyFiles "$INSTDIR\files\ca.cer" "$PROGRAMFILES\Openvpn\config\"
 CopyFiles "$INSTDIR\files\yourpacs.cer" "$PROGRAMFILES\Openvpn\config\"
 CopyFiles "$INSTDIR\files\yourpacs.key" "$PROGRAMFILES\Openvpn\config\"
 CopyFiles "$INSTDIR\files\yourpacs.ovpn" "$PROGRAMFILES\Openvpn\config\"
 DetailPrint "Finished OpenVPN Setup"
 
SectionEnd

Section "ClearCanvas Viewer (a viewer is required)" SecClearCanvas
 SectionIn RO
 DetailPrint "Installing ClearCanvas Viewer..."
 ExecWait '"$INSTDIR\files\CCWorkstation2.0SP1.exe" /S /D=C:\Yourpacs\Clearcanvas' $ClearCanvasError
 CopyFiles "$INSTDIR\files\ClearCanvas.Server.ShredHostService.exe.config" "C:\Yourpacs\Clearcanvas\"
 CopyFiles "$INSTDIR\files\DicomAEServers.xml" "C:\Yourpacs\Clearcanvas\"
 DetailPrint "Finished ClearCanvas Setup"
 
SectionEnd

Section "Configuration tool (required)" SecConfig
	SectionIn RO
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
  !insertmacro MUI_DESCRIPTION_TEXT ${SecBase} $(DESC_SecBase)
  !insertmacro MUI_DESCRIPTION_TEXT ${SecOpenVPN} $(DESC_SecOpenVPN)
  !insertmacro MUI_DESCRIPTION_TEXT ${SecClearCanvas} $(DESC_SecClearCanvas)
  !insertmacro MUI_DESCRIPTION_TEXT ${SecConfig} $(DESC_SecConfig)
!insertmacro MUI_FUNCTION_DESCRIPTION_END
