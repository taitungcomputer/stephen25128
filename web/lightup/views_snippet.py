def income_list(request):
    incomes = Income.objects.all().order_by("-record_date")
    return render(request, "lightup/income_list.html", {"incomes": incomes})
