import os
import json
from django.shortcuts import render
from django.http import JsonResponse

def home(request):
    return render(request, "index.html")

def api_view(request):
    # 直接回傳 JSON，Node-RED 就能讀到
    file_path = os.path.join("data", "api.json")
    try:
        with open(file_path, "r", encoding="utf-8") as f:
            data = json.load(f)
    except Exception as e:
        data = {"error": str(e)}
    return JsonResponse(data)
