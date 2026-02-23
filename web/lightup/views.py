#import pandas as pd
from django.http import HttpResponse
from django.shortcuts import render
#from .forms import UploadCSVForm

from lightup.models import Income, Member, Outcome

# Create your views here.

'''
def upload_csv(request):
    result = None
    columns = None
    error = None

    if request.method == "POST":
        file = request.FILES.get('file')
        if file:
            try:
                df = pd.read_csv(file)
                columns = df.columns.tolist()

                groupby_col = request.POST.get('groupby_column')
                sum_col = request.POST.get('sum_column')
                start_date = request.POST.get('start_date')
                end_date = request.POST.get('end_date')

                if start_date and end_date and "date" in df.columns:
                    df['date'] = pd.to_datetime(df['date'], errors='coerce')
                    df = df[(df['date'] >= pd.to_datetime(start_date)) & (df['date'] <= pd.to_datetime(end_date))]

                if groupby_col and sum_col and groupby_col in df.columns and sum_col in df.columns:
                    result = df.groupby(groupby_col)[sum_col].sum().reset_index()

            except Exception as e:
                error = str(e)
        else:
            error = "請先上傳 CSV 檔案"

    return render(request, "upload_csv.html", {"columns": columns, "result": result, "error": error})

'''

def home(request):
    return HttpResponse(
        "<p style=font-size:24px><marquee>Welcome To lightUP Baptist Church</marquee></p>"
    )


def member_list(request):
    members = Member.objects.all()
    return render(request, "lightup/member_list.html", {"members": members})


def member_detail(request, member_id):
    member = Member.objects.get(id=member_id)
    return render(request, "lightup/member_detail.html", {"member": member})


def income_list(request):
    incomes = Income.objects.all().order_by("-record_date")
    return render(request, "lightup/income_list.html", {"incomes": incomes})


def outcome_list(request):
    outcomes = Outcome.objects.all().order_by("-record_date")
    return render(request, "lightup/outcome_list.html", {"outcomes": outcomes})