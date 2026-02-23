from django import forms

class UploadCSVForm(forms.Form):
    file = forms.FileField()

class UploadForm(forms.Form):
    csv_file = forms.FileField(label="上傳 EXCEL")
    start_date = forms.DateField(widget=forms.DateInput(attrs={'type': 'date'}))
    end_date = forms.DateField(widget=forms.DateInput(attrs={'type': 'date'}))
    group_field = forms.ChoiceField(
        choices=[
            ('編號名稱', '編號名稱'),
            ('項目明細', '項目明細'),
            ('收支別', '收支別'),
        ],
        label="選擇 統計 欄位"
    )
