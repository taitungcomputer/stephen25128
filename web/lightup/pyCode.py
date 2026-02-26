import re
from pathlib import Path

from django.conf import settings
from django.shortcuts import render

from pathlib import Path
from django.conf import settings
from django.shortcuts import render

def letters(request):
    query = request.GET.get("q", "")
    results = {}
    file_path = Path(settings.BASE_DIR) / "lightup" / "letters.txt"

    # 讀取檔案
    with open(file_path, "r", encoding="utf-8") as f:
        content = f.read()

    # 分隔
    blocks = content.split("---------------")
    for block in blocks:
        block = block.strip()
        if block.startswith("信件") or block.startswith("標題"):
            lines = block.splitlines()
            title = lines[0].strip()
            body = "\n".join(lines[1:])
            results[title] = body

    # 如果有搜尋字串，就過濾 (標題或內容都能比對)
    filtered = {}
    if query:
        for title, body in results.items():
            if query in title or query in body:
                filtered[title] = body
    else:
        filtered = results

    return render(request, "lightup/letters.html", {"results": filtered, "query": query})



def happiness(request):
    template_name = "lightup/happiness.html"
    file_path = Path(settings.BASE_DIR) / "lightup" / "happiness16.txt"
    try:
        with file_path.open("r", encoding="utf-8") as f:
            text = f.read()
    except FileNotFoundError:
        return render(request, template_name, {"error": f"檔案不存在：{file_path}"})

    keyword = request.GET.get("kword", "春季第三週").strip()

    # 要排除的雜訊片段
    noise_list = [
        "跳到主要內容司提反的幸福小組話語材料搜尋搜尋此網誌春季第三週月真幸福",
        "分享取得連結以電子郵件傳送其他應用程式張貼留言閱讀完整內容封存月標籤施智元春季幸福小組秋季幸福小組雙翼教會雙翼養育系統檢舉濫用情形技術提供",
    ]

    results = []
    start_pos = 0
    while True:
        pos = text.find(keyword, start_pos)
        if pos == -1:
            break

        # 找下一個分隔符號 "-------"
        sep_pos = text.find("-------", pos)
        if sep_pos == -1:
            end = len(text)
        else:
            end = sep_pos

        segment = text[pos:end].strip()

        # 過濾掉雜訊片段
        for noise in noise_list:
            segment = segment.replace(noise, "")

        if segment:
            # 方法 1：用標點符號斷句，加上換行
            segment = re.sub(r"([。！？])", r"\1\n", segment)

            # 方法 2：把整段包成 HTML <p>，每行再用 <br> 顯示
            html_block = "<p>" + segment.replace("\n", "<br>") + "</p>"
            results.append(html_block)

        start_pos = end + len("-------")

    request.session["rslist"] = [(i + 1, s) for i, s in enumerate(results)]

    return render(
        request,
        template_name,
        {
            "keyword": keyword,
            "results": results,
            "count": len(results),
        },
    )


def engBible(request):
    template_name = "lightup/engbible.html"
    file_path = Path(settings.BASE_DIR) / "lightup" / "niv.txt"
    # file_path = os.path.join(BASE_DIR, "ChineseBible.txt")
    try:
        with file_path.open("r", encoding="utf-8") as f:
            text = f.read()
    except FileNotFoundError:
        return render(request, template_name, {"error": f"file not exist：{file_path}"})

    keyword = request.GET.get("kword", "Jesus").strip()
    k = int(request.GET.get("klength", "20").strip())

    results = []
    start_pos = 0
    while True:
        pos = text.find(keyword, start_pos)
        if pos == -1:
            break
        start = max(0, pos - k)
        end = min(len(text), pos + len(keyword) + k)
        results.append(text[start:end])
        start_pos = pos + len(keyword)

    request.session["rslist"] = [(i + 1, s) for i, s in enumerate(results)]

    return render(
        request,
        template_name,
        {
            "keyword": keyword,
            "k": k,
            "results": results,
            "count": len(results),
        },
    )


def chineseBible(request):
    template_name = "lightup/chinesebible.html"
    file_path = Path(settings.BASE_DIR) / "lightup" / "ChineseBible.txt"
    # file_path = os.path.join(BASE_DIR, "ChineseBible.txt")
    try:
        with file_path.open("r", encoding="utf-8") as f:
            text = f.read()
    except FileNotFoundError:
        return render(request, template_name, {"error": f"檔案不存在：{file_path}"})

    keyword = request.GET.get("kword", "耶穌").strip()
    k = int(request.GET.get("klength", "20").strip())

    results = []
    start_pos = 0
    while True:
        pos = text.find(keyword, start_pos)
        if pos == -1:
            break
        start = max(0, pos - k)
        end = min(len(text), pos + len(keyword) + k)
        results.append(text[start:end])
        start_pos = pos + len(keyword)

    request.session["rslist"] = [(i + 1, s) for i, s in enumerate(results)]

    return render(
        request,
        template_name,
        {
            "keyword": keyword,
            "k": k,
            "results": results,
            "count": len(results),
        },
    )


def hello(request):
    return render(request, "lightup/hello.html", {"k": "ok"})
