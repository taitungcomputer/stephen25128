from django.http import HttpResponse
import csv
import random
from django.shortcuts import render

def get_csv_data_en():
    data = []
    with open("applications/vocabulary.csv", newline="", encoding="utf-8") as csvfile:
        reader = csv.DictReader(csvfile)
        for row in reader:
            data.append(row)
    return data

def vocabulary(request):
    data = get_csv_data_en()

    # 先檢查是否有指定題目索引
    idx = request.GET.get("idx")
    if idx is not None and idx.isdigit():
        idx = int(idx)
        if 0 <= idx < len(data):
            question = data[idx]
        else:
            # 如果 idx 不合法，重新抽一題
            idx = random.randrange(len(data))
            question = data[idx]
    else:
        # 沒有 idx → 下一題，重新抽
        idx = random.randrange(len(data))
        question = data[idx]

    show_answer = request.GET.get("show_answer", False)

    return render(request, "applications/vocabulary.html", {
        "question": question["題目"],
        "answer": question["答案"] if show_answer else None,
        "idx": idx
    })



def get_csv_data_br():
    data = []
    with open("applications/biblereview.csv", newline="", encoding="utf-8") as csvfile:
        reader = csv.DictReader(csvfile)
        for row in reader:
            data.append(row)
    return data

def biblereview(request):
    data = get_csv_data_br()

    # 先檢查是否有指定題目索引
    idx = request.GET.get("idx")
    if idx is not None and idx.isdigit():
        idx = int(idx)
        if 0 <= idx < len(data):
            question = data[idx]
        else:
            # 如果 idx 不合法，重新抽一題
            idx = random.randrange(len(data))
            question = data[idx]
    else:
        # 沒有 idx → 下一題，重新抽
        idx = random.randrange(len(data))
        question = data[idx]

    show_answer = request.GET.get("show_answer", False)

    return render(request, "applications/biblereview.html", {
        "question": question["題目"],
        "answer": question["答案"] if show_answer else None,
        "idx": idx
    })



def get_csv_data():
    data = []
    with open("applications/questions.csv", newline="", encoding="utf-8") as csvfile:
        reader = csv.DictReader(csvfile)
        for row in reader:
            data.append(row)
    return data

def quiz_view(request):
    data = get_csv_data()

    # 先檢查是否有指定題目索引
    idx = request.GET.get("idx")
    if idx is not None and idx.isdigit():
        idx = int(idx)
        if 0 <= idx < len(data):
            question = data[idx]
        else:
            # 如果 idx 不合法，重新抽一題
            idx = random.randrange(len(data))
            question = data[idx]
    else:
        # 沒有 idx → 下一題，重新抽
        idx = random.randrange(len(data))
        question = data[idx]

    show_answer = request.GET.get("show_answer", False)

    return render(request, "applications/quiz.html", {
        "question": question["題目"],
        "answer": question["答案"] if show_answer else None,
        "idx": idx
    })


# Create your views here.
def hello(request):
    #return HttpResponse("hi~")
    name = "Kelly"
    return render(request, "applications/welcome.html", {"name":name})

def dd(request):
    from datetime import datetime

    # 取得現在時間
    now = datetime.now()

    # 分別取出年月日時分秒
    year = now.year
    month = now.month
    day = now.day
    hour = now.hour
    minute = now.minute
    second = now.second

    name = f"{year}-{month}-{day} {hour}:{minute}:{second}"

    return render(request, "applications/now.html",{"name":name})

def search(request):
    colors = request.GET.getlist("color")
    return HttpResponse(f"選擇:{','.join(colors)}")

def tt(request, name):
    return HttpResponse(f"hello, {name}!")

def detail(reuest, year, month, slug):
    return HttpResponse(f"文章: {year} - {month} - {slug}")

def bmi(request):
    # 先統一取得輸入
    if request.method == "POST":
        w = request.POST.get("w")
        h = request.POST.get("h")
    else:
        w = request.GET.get("w")
        h = request.GET.get("h")

    bmi = ""
    try:
        if w and h:  # 確認有輸入才轉型
            w = int(w)
            h = int(h)
            bmi = round(w / ((h / 100) ** 2), 1)
    except ValueError:
        bmi = ""

    return render(request, "applications/bmi.html", {"w": w, "h": h, "bmi": bmi})

