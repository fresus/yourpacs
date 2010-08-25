Imports System
Imports System.Net
Imports System.IO
Imports System.Text
Imports System.ServiceProcess

Public Class YourpacsSetup

    Private Sub Form1_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load

    End Sub

    Private Sub FontDialog1_Apply(ByVal sender As System.Object, ByVal e As System.EventArgs)

    End Sub

    Private Sub GroupBox1_Enter(ByVal sender As System.Object, ByVal e As System.EventArgs)

    End Sub

    Private Sub Label1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Label1.Click

    End Sub

    Private Sub MaskedTextBox1_MaskInputRejected(ByVal sender As System.Object, ByVal e As System.Windows.Forms.MaskInputRejectedEventArgs)

    End Sub

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Run.Click
        Dim request = HttpWebRequest.Create("http://www.yourpacs.com/en/autosetup")
        request.Method = "POST"
        request.ContentType = "application/x-www-form-urlencoded"

        Dim postData As String = "user=" & TextBox1.Text & "&pass=" & TextBox2.Text

        Dim byteArray As Byte() = Encoding.UTF8.GetBytes(postData)
        request.ContentLength = byteArray.Length

        Dim dataStream As Stream = request.GetRequestStream()
        dataStream.Write(byteArray, 0, byteArray.Length)
        dataStream.Close()

        Dim response = request.GetResponse()
        Dim answer As String

        Using reader = New StreamReader(response.GetResponseStream())
            answer = reader.ReadToEnd()
        End Using

        If (answer.Substring(0, 2).Equals("OK")) Then
            MsgBox("Logged in!")
            editConfiguration(TextBox1.Text)
            Application.Exit()
        Else
            MsgBox("Incorrect credentials!")
        End If
    End Sub

    Private Sub editConfiguration(ByVal user As String)
        Dim ClearCanvasAETFile As String = "DicomAEServers.xml"
        Dim ClearCanvasConfigFile As String = "ClearCanvas.Server.ShredHostService.exe.config"

        Try
            Directory.SetCurrentDirectory("files")
        Catch ex As Exception

        End Try

        Try
            ' Edit file1
            Dim buff As String = ""
            Dim sr As StreamReader = New StreamReader(ClearCanvasAETFile)
            Dim line As String = ""
            Do
                line = sr.ReadLine()
                If line <> Nothing Then
                    line = line.Replace("__UPAETITLE__", user.ToUpper())
                    buff = buff + line.Replace("__DOWNAETITLE__", user.ToLower()) + vbCrLf
                End If
            Loop Until line = Nothing
            sr.Close()
            Dim sw As StreamWriter = New StreamWriter("C:\Yourpacs\ClearCanvas\" + ClearCanvasAETFile)
            sw.Write(buff)
            sw.Close()

            ' Edit file2
            buff = ""
            sr = New StreamReader(ClearCanvasConfigFile)
            line = ""
            Do
                line = sr.ReadLine()
                If line <> Nothing Then
                    line = line.Replace("__UPAETITLE__", user.ToUpper())
                    buff = buff + line.Replace("__DOWNAETITLE__", user.ToLower()) + vbCrLf
                End If
            Loop Until line = Nothing
            sr.Close()
            sw = New StreamWriter("C:\Yourpacs\ClearCanvas\" + ClearCanvasConfigFile)
            sw.Write(buff)
            sw.Close()

            ' Restart Clear canvas service
            Dim controller As New ServiceController("ClearCanvas Workstation Shred Host Service")
            controller.Stop()
            controller.WaitForStatus(ServiceControllerStatus.Stopped)
            controller.Start()

            ' All work done!
            MsgBox("YourPACS configured as user " + user)
        Catch ex As Exception
            MsgBox(ex.ToString)
        End Try

    End Sub




    Private Sub Label3_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Label3.Click

    End Sub
End Class
