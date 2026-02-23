FROM python:3.12-slim

ENV PYTHONUNBUFFERED 1

WORKDIR /app

# 安裝系統必要套件
RUN apt-get update && apt-get install -y \
    default-libmysqlclient-dev \
    build-essential \
    pkg-config \
    libmariadb-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 複製 requirements 並安裝 Python 套件
COPY requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt
RUN pip install --no-cache-dir Pillow


# 安裝 MySQL client（如果你真的要用 MySQL）
RUN pip install mysqlclient

# 複製整個 Django 專案
COPY . .

# 預設執行
CMD ["gunicorn", "myproject.wsgi:application", "--bind", "0.0.0.0:8000", "--reload"]



