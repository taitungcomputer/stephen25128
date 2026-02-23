import random

from django.shortcuts import render

# from django.http import HttpResponse

# Create your views here.

def guess(request):
    cka = []
    ckb = []
    if "answer" not in request.session:
        ns = []
        while len(ns) < 4:
            n = random.randint(1, 9)
            if n not in ns:
               ns.append(n)
        request.session["answer"] = "".join(str(n) for n in ns)
        request.session["attempts"] = 0
        request.session["rslista"] = []
    ks = request.session["answer"]
    bs = request.GET.get("number","0000").strip()
    cc = request.GET.get("dd","no").strip()

    #request.session["attempts"] = request.session.get("attempts",0)
    #attempts = 10 - request.session.get("attempts",0)

    if cc == 'renew':
        del request.session["attempts"]
        del request.session["rslista"]
        del request.session["answer"]
    if ks == bs:
        check = "成功, GAMEOVER"
        request.session.flush()

    for ck in ks:
        for cb in bs:
            if cb == ck:
               ckb.append(cb)

    for i in range(4):
        if ks[i] == bs[i]:
            cka.append(ks[i])

    A = len(cka)
    B = len(ckb) - len(cka)
    request.session["attempts"] = request.session.get("attempts",0)+1
    attempts = 11 - request.session.get("attempts",0)
    rs = f'{A}A{B}B'
    rslista = request.session.get("rslista",[])
    if bs != "0000":
        rslista.append((bs,rs))
    request.session["rslista"]= rslista
    if attempts ==0:
        check = "惜敗, GAMEOVER"
        request.session.flush()
    return render(request,"myapp/guess.html",locals())


def practice01(request,id):
    return render(request,"myapp/practice01.html",{"id":id})


def countbmi(request):
    h = request.GET.get("h", "165").strip()
    w = request.GET.get("w", "65").strip()
    h = int(h)
    w = int(w)
    bmi = w / ((h / 100) * (h / 100))

    return render(request, "myapp/countbmi.html", {"h": h, "w": w, "bmi": bmi})


def countsqare(request):
    h = request.GET.get("k", "1").strip()
    h = int(h)
    rs = h * h
    return render(request, "myapp/square.html", {"rs": rs, "h": h})


def lotto(request):
    name = "lotto"
    return render(request, "myapp/lotto.html", {"k": name})


def luckyNumber(request):
    k = []
    s = []
    while len(k) < 7:
        x = random.randint(1, 42)
        s.append(x)
        if x not in k:
            k.append(x)
    return render(request, "myapp/showout.html", {"all": s, "lucky": k})
