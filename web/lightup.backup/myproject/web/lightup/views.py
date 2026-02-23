from django.http import HttpResponse

# Create your views here.


def home(request):
    return HttpResponse(
        "<p style=font-size:24px><marquee>Welcome To lightUP Baptist Church</marquee></p>"
    )
